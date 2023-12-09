# Create a MySQL database and tables for BookMCC

## BookMCC - Entity-Relationship Diagram (ERD)

```
  [Users]                [Books]                [Comments]
 (UserID PK) --1----*-- (BookID PK) --1----*-- (CommentID PK)
 (Email)                (UserID FK)            (BookID FK)
 (Password)             (Title)                (UserID FK)
 (Username)             (Author)               (CommentText)
 (RegistrationTime)     (ISBN-13)              (CommentTime)
                        (ISBN-10)
                        (Image)
                        (CourseName)
                        (Note)
                        (PostTime)
```

## Create the Database and Tables

```bash
# Connect to MySQL in the Docker container
$ docker-compose exec db bash
$ mysql -u root -p
```

Excute the SQL statements in the file `db/database.sql` to create the database and tables.

After creating the database and tables, you can check them by the following commands:

```bash
mysql> SHOW DATABASES;
+--------------------+
| Database           |
+--------------------+
| bookmcc            |
| information_schema |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
5 rows in set (0.00 sec)
```

```sql
mysql> SHOW TABLES;
+-------------------+
| Tables_in_bookmcc |
+-------------------+
| Books             |
| Comments          |
| Users             |
+-------------------+
3 rows in set (0.01 sec)
```

## Backup and Restore the Database

```bash
# Backup the database to a backup file
# There's no space between -p and [password]
# docker exec -it [container_name_or_id] mysqldump -u[user] -p[password] [database_name] > [backup_file_name].sql
# For example:
$ docker exec -it bookmcc-db-1 mysqldump -u root -prootpassword bookmcc > ./db/backup-bookmcc-20231208.sql
```

```bash
# Restore the database from a backup file
# For example:
$ docker exec -i bookmcc-db-1 mysql -u root -prootpassword bookmcc < ./db/backup-bookmcc-20231208.sql
```
