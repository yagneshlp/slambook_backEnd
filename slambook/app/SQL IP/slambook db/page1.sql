use slambook;
create table page1(
  userid int primary key,
  user_name varchar(50) not null,
  full_name varchar(200) not null,
  nick_name varchar(100) not null,
  date_of_birth date not null );
select * from page1;  

  