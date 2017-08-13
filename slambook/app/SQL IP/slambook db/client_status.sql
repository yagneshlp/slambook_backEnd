use slambook;
create table client_status(
  userid int primary key,
  user_name varchar(50) not null,
  last_login datetime ,
  progress int ,
  reminderIfSet_time datetime ,
  requireATTENTION bool );
  
select * from client_status;

