#!/bin/bash

if [ -f ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock ]; then
 exit 0;
fi

DBPASS=`cat ../config.php | grep -i "DB_PASS" | grep -i define | awk '{print $2}' | cut -d "'" -f 2`
ADMINGROUP=$1
EMAILID=$2
USERNAME=$5
PLATFORM=$4
FILENAME=$6

echo "userIp  username  UserFullName      UserFullName    platform        shiftstart	shiftend	loginDate	loginTime       LoginType       operation       workhours" > ../tmp/user_data_fetch_$FILENAME.txt

if [ "$PLATFORM" == "$ADMINGROUP" ] || [ "$ADMINGROUP" == "all" ]; then

mysql -u logintracking -p$DBPASS logintracking -e "select userIp, username, UserFullName, platform, shifttime, loginTime, LoginType, operation, workhours from userlog where username='$USERNAME';" | grep -Pv "userIp\tusername" >> ../tmp/user_data_fetch_$FILENAME.txt

echo "Single User $USERNAME data, see attached file !" | mailx -s "ALL User data for specific Month, see attached file !" -r Login-Management-System@list.lilly.com -a ../tmp/user_data_fetch_$FILENAME.txt $EMAILID

else

echo "You are not entitled to see $USERNAME data because your group is $ADMINGROUP and user group is $PLATFORM, which is different" | mailx -s "Access denied to see user data ..!" -r Login-Management-System@list.lilly.com $EMAILID

fi

rm -rf ../tmp/user_data_fetch_$FILENAME.txt

touch ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock
sleep 5 
rm -rf ../tmp/adminmail_user_data_fetch_for_all_platform.sh.lock
