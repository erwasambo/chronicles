vagrant-lamp-ansible
----------------------

This is a simple recipe for *vagrant* that sets up an Ubuntu virtual machine including common daemons and tools required for PHP web development.

You might also be interested in this presentation, which extols the virtues of using Vagrant for PHP development: http://loevborg.karmafish.net/laravel4-pocket/#/laravel-in-your-pocket

Specifically this recipe automatically installs:

- Ubuntu 12.04 (precise), 64bit version
- PHP 5.5
- MySQL
- phpMyAdmin
- beanstalkd
- memcached
- asset comilation tools
    - compass
    - node.js

This recipe uses the excellent `ansible` as a provisioning tool for *vagrant*. It does not use vagrant's `ansible` plugin, however, because that plugin controls the VM via SSH from the outside (which won't work easily on Windows hosts).

Instead, this recipe runs `ansible` in its "local" mode (using `-c local`). As a result, you don't have to install ansible on the host machine. See `ansible/provision.sh` for details.

To get started, install

- Vagrant (http://www.vagrantup.com/)
- VirtualBox (https://www.virtualbox.org/)

preferably in their latest versions from the web sites.

Then clone this repository to a local directory. After changing into the directory, run:

    vagrant up

This should download, run and provision the virtual machine.

If something goes wrong, have a look at `ansible/playbook.yml`, which contains the provisioning recipe. You can re-provision the VM using:

    vagrant provision

After bringing up the virtual machine, open this url in your browser: http://localhost:8888/. You should be greeted by the `phpinfo()` output from public/index.php.

When you're done playing with the VM, you can delete it:

    vagrant destroy
=======
# chronicles

1.  Set up basic Orchestrated environment using Vagrant and Ansible at https://github.com/pesterhazy/vagrant-lamp-ansible
2.  Get a complete startter kit for codeIgniter at https://github.com/JasonBaier/ci3-fire-starter and https://github.com/JasonBaier/ci-fire-starter for version 2.0.x
3. Worry about the business logic

checkout https://github.com/gocardless/codeigniter-gocardless and https://gocardless.com/
https://github.com/paymill/paymill-example-php-subscriptions.git
https://registry.hub.docker.com/u/turnkeylinux/codeigniter-13.0/tags/manage/
https://registry.hub.docker.com/u/dgraziotin/lamp/
https://registry.hub.docker.com/u/linode/lamp/
https://gocartdv.com/
https://www.calazan.com/docker-cleanup-commands/
