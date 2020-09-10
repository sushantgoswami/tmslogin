#!/bin/bash

PASS=$1
echo $PASS | openssl enc -aes-128-cbc -a -salt -pass pass:tcs50
