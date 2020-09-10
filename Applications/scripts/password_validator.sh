#!/bin/bash

PASS=$1
HASH=$2

if [ "$PASS" == "$HASH" ]; then
 echo 1;
else
 echo 0;
fi
