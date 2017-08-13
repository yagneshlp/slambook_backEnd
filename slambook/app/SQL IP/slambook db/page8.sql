use slambook;
create table page8(
  userid int primary key,
  user_name varchar(50) not null,
  earbug_SONGNAME varchar(100) not null,
  earbug_ARTIST varchar(100) not null,
  playlist text not null);
  
select * from page8;