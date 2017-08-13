use slambook;
create table page19(
  userid int primary key,
  user_name varchar(50) not null,
  firstImpression text not null,
  didILIveUptoThatImpression varchar(10) not null,
  currentImpression text not null);
  
select * from page19;