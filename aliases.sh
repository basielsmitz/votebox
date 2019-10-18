alias ..='cd ..'
alias ...='cd ../..'

alias h='cd ~'
alias c='clear'
alias art='artisan'

alias p='cd ~/Code/nmdad2-19-votebox'
p

alias x='exit'

alias serve=serve-laravel

alias xoff='sudo phpdismod -s cli xdebug'
alias xon='sudo phpenmod -s cli xdebug'

# Convenience aliases
alias ResetComposer='rm -rf /home/vagrant/.composer/'
alias UpdateComposer='sudo composer self-update'
alias InstallComposerCgr='composer g require consolidation/cgr'
alias db='MYSQL_PWD=secret mysql --user=homestead'
alias UpgradeUbuntu='sudo apt-get update && sudo apt-get upgrade -y && sudo apt-get dist-upgrade && sudo apt-get autoremove -y'
alias RestartServices='sudo service nginx restart && sudo service php7.0-fpm restart'

# Preserve environment variables for Super User Do
alias sudo='sudo -E'

function artisan() {
    if [ -d laravel ]
    then 
        cd laravel
    fi
    if [ -f artisan ]
    then
        php artisan "$@"
    else
        echo "Laravel Artisan is not available from this directory!"
    fi
}

function behat() {
    if [ -f bin/behat ]
    then
        php bin/behat "$@"
    else
        if [ -f vendor/bin/behat ]
        then
            php vendor/bin/behat "$@"
        else
            command phpunit "$@"
        fi
    fi
}

function console() {
    if [ -d symfony ]
    then 
        cd symfony
    fi
    if [ -f bin/console ]
    then
        php bin/console "$@"
    else
        if [ -f app/console ]
        then
            php app/console "$@"
        else
            echo "Symfony Console is not available from this directory!"
        fi
    fi
}

function phpspec() {
    if [ -f bin/phpspec ]
    then
        php bin/phpspec "$@"
    else
        if [ -f vendor/bin/phpspec ]
        then
            php vendor/bin/phpspec "$@"
        else
            command phpspec "$@"
        fi
    fi
}

function phpunit() {
    if [ -f bin/phpunit ]
    then
        php bin/phpunit "$@"
    else
        if [ -f vendor/bin/phpunit ]
        then
            php vendor/bin/phpunit "$@"
        else
            command phpunit "$@"
        fi
    fi
}

# Artevelde University College Ghent proxy server on/off
function proxy() {
    case "$1" in
        on)
            PXY=http://proxy.arteveldehs.be:8080
            NOPXY=localhost,127.0.0.1,.local
            export HTTP_PROXY=$PXY HTTPS_PROXY=$PXY FTP_PROXY=$PXY NO_PROXY=$NOPXY http_proxy=$PXY https_proxy=$PXY ftp_proxy=$PXY no_proxy=$NOPXY
            unset PXY NOPXY
            echo "Artevelde University College Ghent proxy server settings are SET"
            ;;
        off)
            unset HTTP_PROXY HTTPS_PROXY FTP_PROXY NO_PROXY http_proxy https_proxy
            echo "Artevelde University College Ghent proxy server settings are UNSET"
            ;;
        *)
            echo "Error: missing required parameter."
            echo "Usage: "
            echo "  proxy on"
            echo "  proxy off"
            echo "Proxy Server Settings: $HTTP_PROXY | Proxy Server Exceptions: $NO_PROXY"
            ;;
    esac
}

function serve-apache() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-apache.sh
        sudo bash /vagrant/scripts/serve-apache.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve-apache domain path"
    fi
}

function serve-laravel() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-laravel.sh
        sudo bash /vagrant/scripts/serve-laravel.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve domain path"
    fi
}

function serve-proxy() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-proxy.sh
        sudo bash /vagrant/scripts/serve-proxy.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve-proxy domain port"
    fi
}

function serve-silverstripe() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-silverstripe.sh
        sudo bash /vagrant/scripts/serve-silverstripe.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve-silverstripe domain path"
    fi
}

function serve-statamic() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-statamic.sh
        sudo bash /vagrant/scripts/serve-statamic.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve-statamic domain path"
    fi
}

function serve-symfony2() {
    if [[ "$1" && "$2" ]]
    then
        sudo dos2unix /vagrant/scripts/serve-symfony2.sh
        sudo bash /vagrant/scripts/serve-symfony2.sh "$1" "$2" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  serve-symfony2 domain path"
    fi
}

function share() {
    if [[ "$1" ]]
    then
        ngrok http -host-header="$1" 80
    else
        echo "Error: missing required parameters."
        echo "Usage: "
        echo "  share domain"
    fi
}
