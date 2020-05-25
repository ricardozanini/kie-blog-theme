#!/bin/bash

# based on https://kubernetes.io/docs/tutorials/stateful-application/mysql-wordpress-persistent-volume/

kubectl apply -f local-volumes.yaml

# install kustomize first: https://github.com/kubernetes-sigs/kustomize/blob/master/docs/INSTALL.md
kustomize build . | kubectl apply -f -

# expose the service. see: https://kubernetes.io/docs/tutorials/hello-minikube/
minikube service wordpress

