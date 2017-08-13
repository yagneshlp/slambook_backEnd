use slambook;
create table page23(
  userid int primary key,
  user_name varchar(50) not null,
  bff_access varchar(10) not null,
  personalized_reply varchar(10) not null,
  pdf_required varchar(10) not null,
  date_of_completion date not null);
  
select * from page23;

