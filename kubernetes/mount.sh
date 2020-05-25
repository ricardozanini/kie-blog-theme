#!/bin/bash

# in case of failures due to network error, there's a workaround, that is adding this rule in the firewalld:
# see: https://github.com/kubernetes/minikube/issues/4726
# firewall-cmd --permanent --zone=libvirt --add-rich-rule='rule family="ipv4" source address="192.168.39.0/24" accept'
# firewall-cmd --reload
# firewall-cmd --zone=libvirt --list-all

# mount for development purposes. will update the theme as soon as you 
minikube mount ${HOME}/${SOURCE-CODE}/kogito-blog-theme/theme:/data/pvtheme