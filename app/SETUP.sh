#!/bin/bash
CODENAME=$(lsb_release -sc)
if [ $CODENAME = "xenial" ]; then
     systemctl restart mysql
fi
ln -s /etc/openitcockpit/nagios.cfg /opt/openitc/nagios/etc/nagios.cfg
sudo -g www-data /usr/share/openitcockpit/app/Console/cake schema update --connection default --file schema_itcockpit.php -s 26
#sudo -g www-data /usr/share/openitcockpit/app/Console/cake schema update --plugin NagiosModule --file ndo.php --connection default
oitc AclExtras.AclExtras aco_sync
oitc compress
oitc nagios_export --all

if [ $CODENAME = "jessie" ] || [ $CODENAME = "xenial" ]; then
    systemctl restart nagios
fi

if [ $CODENAME = "trusty" ]; then
    service nagios restart
fi

sudo -g www-data /usr/share/openitcockpit/app/Console/cake setup
