
Joe Freeman's Weblog
Musings on Software Development, etc
Skip to content

    Home
    About

← Lineographic Interpretations of Images, with an Etch-a-sketch
A Java Swing Application for Testing PHP Snippets →
FULLTEXT Search with MySQL and CodeIgniter
Posted on October 26, 2009 by Joe	

I was required to use CodeIgniter for a project recently. I’m generally not a big fan of the framework, but I have grown to like aspects of it. A lot of people seem to praise the documentation, the mass of examples and the active community. Maybe my hopes were set too high, but I was disappointed with all of these.

The thing I like about using a framework is being told how to do things, but for many the big attraction to CodeIgniter seems to be that it’s lightweight and you can do things how you like. I think this is the reason for the inconsistencies and low quality of example code. So I thought that I’d put together an article and example project showing a few of the tricks I’ve learnt, and my preferred CodeIgniter style.

I’m going to put together a simple application which shows off the search capabilities of MySQL, whilst exploring some of CodeIgniter’s features.
Getting CodeIgniter Ready

This is pretty basic stuff. Download, unzip, and dump the files somewhere into your web server’s directory. Setup a MySQL database and associated user and fill in the connection details in application/config/database.php.

Open up application/config/config.php and edit the base_url setting. This needs to be the web-visible URL to the directory that you put the CodeIgniter files into. If you did put them into your local web server’s root directory, this may be as simple as ‘http://localhost/’.
Setting Up the Database

You should already have a database setup, but we need a table to store the data. I’ve created a simple ‘pages’ table. To make use of MySQL’s FULLTEXT search capabilities, you must setup an index on any fields that you want to be searchable. See the the SQL below:

CREATE TABLE pages (
  id int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  url text NOT NULL,
  title text NOT NULL,
  content text NOT NULL,
  updated datetime NOT NULL,
  PRIMARY KEY  (id),
  FULLTEXT KEY content (content)
) ENGINE=MyISAM

I’ve setup an index on the ‘content’ field so that it will be searchable. Note also that FULLTEXT search is only available when using the MyISAM engine.
Some Test Data

In order to perform a decent evaluation of the searching mechanism, I realised that I would need some substantial data. I decided Wikipedia would make a good source of this data. Rather than export all three million articles, I limited myself to about two thousand of the featured articles. I setup a script to scrape the list of featured articles and then used the Wikipedia export feature to automatically copy across all the data into my database.

After over-coming an issue with the character encoding it soon because obvious that the Wikipedia markup wasn’t quite the format that I wanted. Hacking together a few regular expressions meant I could strip most of this out, leaving plain and readable content.
Searching the Data

At this point, the magic SQL to use takes the form: MATCH (columns) AGAINST ('terms'). Note that when MATCH ... AGAINST is used in the WHERE clause, the results are automatically sorted, so there’s no need to add an ORDER BY clause. An example:

SELECT *
FROM pages
WHERE MATCH (content) AGAINST ('test') > 0

There are a few FULLTEXT gotchas you should be aware of:

    Something that I was stung by: if you have fewer than three rows of data, you won’t get any search results back.
    Search strings have a minimum length. This is generally three or four characters, but depends on configuration. See below.
    There is a collection of ‘stopwords‘ that MySQL will ignore (words like ‘the’, ‘however’, ‘hello’). If you try a search for any of these, you won’t get any results back.

You can find out some of the configuration details by executing SHOW VARIABLES LIKE 'ft%'. You should get something like this:

mysql-variables

A few different ‘modes’ are available for searching. By default, a natural language search is performed. A boolean search is also possible, and allows a number of powerful operators to be used – refer to the documentation for details.

It is also possible to use query expansion. This roughly means that the search may return items where the search terms aren’t actually in the content, but instead there are words that are deemed similar. This is achieved by performing two searches. Where the second search uses content from high-ranking rows in the first search to perform the second search. This only tends to work well for short queries, otherwise less-relevant results will be returned.

More details on the full-text functionality can be found in the MySQL documentation.
CodeIgniter and the MVC Pattern

Let us return our attention to CodeIgniter…

The framework takes advantage of the ever-popular model-view-controller (MVC) pattern. Everyone knows you’re supposed to separate your domain-logic from presentation code, but the nice thing about the MVC pattern is that it’s constantly there to remind you.

I stick to a few basic rules:

    you can only touch the database from within the model
    nothing should be echo-ed from the controller (or the model)
    only one statement can appear inside each set of <?php-tags and it should generally be either en echo or a control structure (use the alternative syntax)

If you find yourself breaking any of these rules, it’s probably a sign that it’s time to step back and re-think what you’re trying to achieve.

Let’s start off with the model. I only have one method here, which performs the searching. You may note that I’m using raw SQL here rather than using CodeIgniter’s Active Record implementation. This is just a personal preference – I think the CodeIgniter implementation is a bit messy compared to something more RoR-like.

The following code needs to go into application/models/page_model.php:

class Page_model extends Model
{
    function Page_model()
    {
        parent::Model();
 
        // Make the database available to all the methods
        $this->load->database();
    }
 
    function search($terms)
    {
        // Execute our SQL statement and return the result
        $sql = "SELECT url, title
                    FROM pages
                    WHERE MATCH (content) AGAINST (?) > 0";
        $query = $this->db->query($sql, array($terms, $terms));
        return $query->result();
    }
}

Next up is the view. Note that I’m religiously using the form helpers. This needs to go into application/views/search_results.php:

<?php $this->load->helper('form'); ?>
 
<?php echo form_open($this->uri->uri_string); ?>
<?php echo form_label('Search:', 'search-box'); ?>
<?php echo form_input(array('name' => 'q', 'id' => 'search-box', 'value' => $search_terms)); ?>
<?php echo form_submit('search', 'Search'); ?>
<?php echo form_close(); ?>
 
<?php if ( ! is_null($results)): ?>
    <?php if (count($results)): ?>
        <ul>
        <?php foreach ($results as $result): ?>
            <li><a href="<?php echo $result->url; ?>"><?php echo $result->title; ?></a></li>
        <?php endforeach ?>
        </ul>
    <?php else: ?>
        <p><em>There are no results for your query.</em></p>
    <?php endif ?>
<?php endif ?>

Finally, pulling both the model and view together with the controller. The following code should go into application/controllers/pages.php:

class Pages extends Controller {
 
    function search($search_terms = '')
    {
        // If the form has been submitted, rewrite the URL so that the search
        // terms can be passed as a parameter to the action. Note that there
        // are some issues with certain characters here.
        if ($this->input->post('q'))
        {
            redirect('/pages/search/' . $this->input->post('q'));
        }
 
        if ($search_terms)
        {
            // Load the model and perform the search
            $this->load->model('page_model');
            $results = $this->page_model->search($search_terms);
        }
 
        // Render the view, passing it the necessary data
        $this->load->view('search_results', array(
            'search_terms' => $search_terms,
            'results' => @$results
        ));
    }
}

At the beginning of the method, there is a reference to a redirect function. This is a helper function, and it’s part of the ‘url’ group of helper functions. To use it, we could load the helper manually using: $this->load->helper('url');. However, because this group of helper functions is quite commonly used, we can load them automatically. To do this, we need to edit the application/config/autoload.php file:

$autoload['helper'] = array('url');

We should now have a working prototype. Make sure you have some data in your database (remember, at least three rows). Then steer your browser to the relevant URL, which should be something like: ‘http://localhost/index.php/pages/search’, enter some text to search (something that you know is in the database) and hit the ‘Search’ button.

You should get something like this:

screenshot-1
Adding More Features

To show off a bit more of CodeIgniter, I’ll add a few more features, including pagination, custom configuration files and custom helpers.

The CodeIgniter user guide boasts that the pagination class is “100% customizable”. I wouldn’t go that far, but you can certainly change a few things.

First of all, we need to modify our model so that it only returns a portion of the results, and also so that we can find out how many results in total our query would return.

The first problem is easily solved by adding an argument to the method, and a LIMIT to our SQL query. For the second problem, there are a few solutions, none of which seem very elegant:

    We can add a separate method to the model, which will return the total number of results. This means that generally we will always have to call both routines. Certainly not a disaster, but it just doesn’t seem very refined.
    Alternatively, we can calculate this count from within our ‘search’ method, and return both a collection of results and the total count together in some form of array structure. This is a bit abusive of the only-return-one thing methodology.
    Or, we can pass a reference parameter to the method, set the value inside the method, and then access this variable from the controller. I think this works quite nicely because it’s discrete, but possibly a bit too subtle to be obvious to other developers.

To keep things simple, I’m going to go with the first option. Let’s refactor the model:

class Page_model extends Model {
 
    // Constructor as before
 
    function search($terms, $start = 0, $results_per_page = 0)
    {
        // Determine whether we need to limit the results
        if ($results_per_page > 0)
        {
            $limit = "LIMIT $start, $results_per_page";
        }
        else
        {
            $limit = '';
        }
 
        // Execute our SQL statement and return the result
        $sql = "SELECT url, title, content
                    FROM pages
                    WHERE MATCH (content) AGAINST (?) > 0
                    $limit";
        $query = $this->db->query($sql, array($terms, $terms));
        return $query->result();
    }
 
    function count_search_results($terms)
    {
        // Run SQL to count the total number of search results
        $sql = "SELECT COUNT(*) AS count
                    FROM pages
                    WHERE MATCH (content) AGAINST (?)";
        $query = $this->db->query($sql, array($terms));
        return $query->row()->count;
    }
}

Note that I’m also returning the ‘content’ field in the SQL – this will be useful later. The next thing to do is to modify our controller. We need to load and initialise the pagination library. Here’s the modified ‘search’ method:

class Pages extends Controller {
 
    function search($search_terms = '', $start = 0)
    {
        // If the form has been submitted, rewrite the URL so that the search
        // terms can be passed as a parameter to the action. Note that there
        // are some issues with certain characters here.
        if ($this->input->post('q'))
        {
            redirect('/pages/search/' . $this->input->post('q'));
        }
 
        if ($search_terms)
        {
            // Determine the number of results to display per page
            $results_per_page = $this->config->item('results_per_page');
 
            // Load the model, perform the search and establish the total
            // number of results
            $this->load->model('page_model');
            $results = $this->page_model->search($search_terms, $start, $results_per_page);
            $total_results = $this->page_model->count_search_results($search_terms);
 
            // Call a method to setup pagination
            $this->_setup_pagination('/pages/search/' . $search_terms . '/', $total_results, $results_per_page);
 
            // Work out which results are being displayed
            $first_result = $start + 1;
            $last_result = min($start + $results_per_page, $total_results);
        }
 
        // Render the view, passing it the necessary data
        $this->load->view('search_results', array(
            'search_terms' => $search_terms,
            'first_result' => @$first_result,
            'last_result' => @$last_result,
            'total_results' => @$total_results,
            'results' => @$results
        ));
    }
 
    function _setup_pagination($url, $total_results, $results_per_page)
    {
        // Ensure the pagination library is loaded
        $this->load->library('pagination');
 
        // This is messy. I'm not sure why the pagination class can't work
        // this out itself...
        $uri_segment = count(explode('/', $url));
 
        // Initialise the pagination class, passing in some minimum parameters
        $this->pagination->initialize(array(
            'base_url' => site_url($url),
            'uri_segment' => $uri_segment,
            'total_rows' => $total_results,
            'per_page' => $results_per_page
        ));
    }
}

Let’s look at the changes we’ve made…

We have added an extra argument to the method. This means the URL will have another (optional) segment to it. It will be a number representing the record that we are starting on, and will get set automatically by the pagination code.

In order to determine the number of results to show on a page at a time, I have used the config library. In order to setup custom configuration for your application, it’s best to add a new file to the application/config directory, then set it to be autoloaded. Edit the application/config/autoload.php file again, and add ‘application’ to the $autoload['config'] array. Then create the application/config/application.php file, and put the following line in it:

$config['results_per_page'] = 10;

The next change we have made is to setup the pagination. I have put this code into a separate method. Note that the method name is prefixed with an underscore. This prevents the private method being called as an action on the controller. The code here is fairly self-explanatory.

We also pass some extra information over to our view. Which leads us to our next task of updating the view. But first, we will write our own custom helper functions for use within the view. These go into application/helpers/search_helper.php. The first function – search_highlight($text, $search_terms) – provides a way to highlight search terms in a string (there is a similar CodeIgniter helper, but it doesn’t quite do what we want). The second function – search_extract($content, $search_terms, $number_of_snippets = 3, $snippet_length = 60) – is a flaky attempt to generate an ‘excerpt’ to accompany each result. An excerpt is made up of a number of ‘snippets’ which should each contain at least one of the search terms. I won’t paste the code here since it’s far from elegant, but it’s available in the download.

Finally, the updated view. Note that we have to manually load the helper before using the helper functions. The pagination links are created using the create_links method.

<?php $this->load->helper(array('form', 'search')); ?>
 
<?php echo form_open($this->uri->uri_string); ?>
<?php echo form_label('Search:', 'search-box'); ?>
<?php echo form_input(array('name' => 'q', 'id' => 'search-box', 'value' => $search_terms)); ?>
<?php echo form_submit('search', 'Search'); ?>
<?php echo form_close(); ?>
 
<?php if ( ! is_null($results)): ?>
    <?php if (count($results)): ?>
 
        <p>Showing search results for '<?php echo $search_terms; ?>' (<?php echo $first_result; ?>&ndash;<?php echo $last_result; ?> of <?php echo $total_results; ?>):</p>
 
        <ul>
        <?php foreach ($results as $result): ?>
            <li><a href="<?php echo $result->url; ?>"><?php echo search_highlight($result->title, $search_terms); ?></a><br /><?php echo search_extract($result->content, $search_terms); ?></li>
        <?php endforeach ?>
        </ul>
 
        <?php echo $this->pagination->create_links(); ?>
 
    <?php else: ?>
        <p><em>There are no results for your query.</em></p>
    <?php endif ?>
<?php endif ?>

Here’s the result of trying it out in the browser again:

screenshot-2
Evaluation

CodeIgniter comes with benchmarking and profiling features. We can mark points in the execution, enable profiling, and have them have them output to the browser. For example, I might add marks around the calls to the model:

// Mark the start of search
$this->benchmark->mark('search_start');
 
// Load the model, perform the search and establish the total
// number of results
$this->load->model('page_model');
$results = $this->page_model->search($search_terms, $start, $results_per_page);
$total_results = $this->page_model->count_search_results($search_terms);
 
// Mark the end of search
$this->benchmark->mark('search_end');

The output at the bottom of the page would look something like this:

profiling

We can see that the search on 1800 rows took 0.0138 seconds. This is 49% of the total execution time.

It is also possible to measure the time it takes to render the view by putting marks in the controller on either side of the $this->load->view(...) call. The view takes about 0.007 seconds to load. Without the generation of a page extract, it takes significantly less time: 0.002 seconds.
Download

I have packaged up the code for this example. Feel free to download it.
Other Search Solutions

There are, of course, other search solutions available. Two such popular projects are Sphinx and Lucene. However, getting them compiled, installed and running doesn’t appear to be any simple task.
This entry was posted in CodeIgniter, MySQL, PHP. Bookmark the permalink.
← Lineographic Interpretations of Images, with an Etch-a-sketch
A Java Swing Application for Testing PHP Snippets →
5 Responses to FULLTEXT Search with MySQL and CodeIgniter

    Robert says:	
    December 11, 2009 at 10:26 am	

    Thank you a lot for sharing this.

    That was sooo helpful.

    I only changed the following in my setup: The default value for $results_per_page I set to 10, and I skipped the following if-statement. Because in your setup if no value is passed to the method it will select all entries. I don’t ever want this, so I changed it.
    mike says:	
    December 21, 2009 at 7:23 pm	

    Hey there, first let me say thanks! This is a great tutorial.

    I’ve converted this to use 2 search fields, one for “keyword(s)” and one for “location” – It works nicely as far as the search part goes but, breaks the pagination. If the user only enters a keyword and no location, then clicks “page 2″, it assumes that “10″ is the location. On the other hand if the user enters keyword and location the pagination works fine… Any tips on how I can tell it that there was no location and to use that part of the uri segment for pagination?

    thanks!
    Joe says:	
    December 21, 2009 at 8:10 pm	

    I think you basically need to have ‘default’ values for your search parameters. For example, you could have:

    function search($keywords = 'none', $location = 'all', $start = 0)

    Then check within the function for these as special cases. You can’t use the empty string (as I have in my example) because by missing it out, the consecutive slashes in the URL will be ignored.

    (I just noticed a bug in my _setup_pagination function by the way—it wasn’t making use of the $uri_segment, which may help you out if you’re using additional URL segments.)
    Yuri says:	
    March 7, 2010 at 1:13 pm	

    Hi, I’m trying to do for your example, but fails to display the search results.
    ‘There are no results for your query.’
    Database I filled the content.
    Maybe I have missed something?
    Joe says:	
    March 20, 2010 at 9:33 pm	

    Hi Yuri. It’s difficult to make guesses without seeing your data and queries. Double-check the ‘FULLTEXT gotchas’ I mention in the ‘Searching the Data’ section.

    Links
        Developer Utilities
        Profile
        Trackt – collaborate online with sticky notes

    Categories
        .NET
            C#
        Erlang
            MochiWeb
        Image Processing
        Java
            Swing
        JavaScript
            Ext JS
        Linux
        MySQL
        PHP
            CodeIgniter

Joe Freeman's Weblog
Proudly powered by WordPress.

