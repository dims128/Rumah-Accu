import pandas as pd

# Baca file Excel
df = pd.read_excel("data kesehatan.xlsx")

# Bersihkan nama kolom
df.columns = df.columns.str.strip()

# Perbaiki nama kolom tahun (ambil hanya 4 digit angka)
cleaned_columns = ['No.', 'Indikator Kesehatan']
for col in df.columns[2:]:
    year = ''.join(filter(str.isdigit, col))
    if len(year) == 4:
        cleaned_columns.append(year)
    else:
        cleaned_columns.append(col)

# Ganti nama kolom
df.columns = cleaned_columns

# Simpan file yang sudah dibersihkan
df.to_excel("indikator_kesehatan_bersih.xlsx", index=False)
print("File berhasil disimpan sebagai indikator_kesehatan_bersih.xlsx")
