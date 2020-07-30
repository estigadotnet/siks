-- select * from
update
	t103_nonrutin
set
	nominal = 0,
	sisa = 0
where
	idsiswa in
    (
select
	a.idsiswa
-- 	, a.*
--     , b.kelas
--     , c.nominal
--     , c.sisa
from
	t004_siswa a
    left join t003_kelas b on a.idkelas = b.idkelas
--     left join t103_nonrutin c on a.idsiswa = c.idsiswa
where
	left(kelas, 1) > '1'
--     and c.idjenis = 1
    )
    and idjenis = 1