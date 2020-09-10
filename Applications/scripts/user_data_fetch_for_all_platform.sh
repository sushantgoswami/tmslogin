#!/bin/bash

if [ -f ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock ]; then
 exit 0;
fi

DBPASS=`cat ../config.php | grep -i "DB_PASS" | grep -i define | awk '{print $2}' | cut -d "'" -f 2`

ADMINGROUP=$1
EMAILID=$2
USERNAME=$3
PLATFORM=$4
FILENAME=$5

if [ ! -z $EMAILID ]; then

echo "userIp  username  UserFullName   UserFullName   platform        shiftstart	shiftend	loginDate	loginTime       LoginType       operation       workhours" > ../tmp/user_data_fetch_$FILENAME.txt

mysql -u logintracking -p$DBPASS logintracking -e "select userName from login;" > ../tmp/user_fetch_$FILENAME.txt

for i in `cat ../tmp/user_fetch_$FILENAME.txt`; do mysql -u logintracking -p$DBPASS logintracking -e "select userIp, username, UserFullName, platform, shifttime, loginTime, LoginType, operation, workhours from userlog where username='$i';"; done | grep -Pv "userIp\tusername" >> ../tmp/user_data_fetch_$FILENAME.txt

echo "ALL User data for all platform, see attached file !" | mailx -s "ALL User data for specific Month, see attached file !" -r Login-Management-System@list.lilly.com -a ../tmp/user_data_fetch_$FILENAME.txt $EMAILID

rm -rf ../tmp/user_fetch_$FILENAME.txt
rm -rf ../tmp/user_data_fetch_$FILENAME.txt

fi

touch ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock
sleep 5 
rm -rf ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock

