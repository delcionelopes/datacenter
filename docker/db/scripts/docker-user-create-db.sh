#!/bin/sh

psql -d template1 -U postgres
psql --command "CREATE USER datacenter WITH PASSWORD '145236';" 
psql --command "CREATE DATABASE datacenter;"
psql --command "GRANT ALL PRIVILEGES ON DATABASE datacenter to datacenter;"
psql --command "\q;"  
psql -U datacenter -d datacenter -f /var/lib/postgresql/backup.sql

exit