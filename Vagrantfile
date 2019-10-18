# -*- mode: ruby -*-
# vi: set ft=ruby :

require 'json'
require 'yaml'

VAGRANTFILE_API_VERSION ||= "2"
confDir = $confDir ||= File.expand_path("vendor/gdmgent/artestead", File.dirname(__FILE__))

artesteadYamlPath = "Artestead.yaml"
artesteadJsonPath = "Artestead.json"
afterScriptPath = "after.sh"
aliasesPath = "aliases.sh"

require File.expand_path(confDir + '/scripts/artestead.rb')

Vagrant.require_version '>= 1.9.2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
    if File.exist? aliasesPath then
        config.vm.provision "file", source: aliasesPath, destination: "/tmp/bash_aliases"
        config.vm.provision "shell" do |s|
            s.inline = "awk '{ sub(\"\r$\", \"\"); print }' /tmp/bash_aliases > /home/vagrant/.bash_aliases"
        end
    end

    if File.exist? artesteadYamlPath then
        settings = YAML::load(File.read(artesteadYamlPath))
    elsif File.exist? artesteadJsonPath then
        settings = JSON.parse(File.read(artesteadJsonPath))
    else
        abort "Artestead settings file not found in #{confDir}"
    end

    Artestead.configure(config, settings)

    if File.exist? afterScriptPath then
        config.vm.provision "shell", path: afterScriptPath, privileged: false
    end

    if defined? VagrantPlugins::HostsUpdater
        config.hostsupdater.aliases = settings['sites'].map { |site| site['map'] }
    end
end
