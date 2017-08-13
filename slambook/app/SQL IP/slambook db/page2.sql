use slambook;
create table page2(
  userid int primary key,
  user_name varchar(50) not null,
  phone_number_PRIMARY varchar(10) not null,
  phone_number_SECONDARY varchar(10) not null,
  phone_number_WHATSAPP varchar(10) not null,
  email_id varchar(150) not null);
  
select * from page2;

