#!/bin/bash

HASH=$1
echo $HASH | openssl enc -aes-128-cbc -a -d -salt -pass pass:tcs50
