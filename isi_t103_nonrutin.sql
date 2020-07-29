insert into t103_nonrutin (idsiswa, idjenis, nominal, sisa)
select
	*
from
	(
select
	a.idsiswa
    , b.id as idjenis
    , 1000000 as nominal
    , 1000000 as sisa
from
	t004_siswa a
    , t005_nonrutin b
where
	b.id = 1

union

select
	a.idsiswa
    , b.id as idjenis
    , 700000 as nominal
    , 700000 as sisa
from
	t004_siswa a
    , t005_nonrutin b
where
	b.id = 2
    ) c
order by
	idsiswa, idjenis