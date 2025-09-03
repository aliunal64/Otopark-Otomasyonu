📌 Proje Hakkında:

🚗 Bu proje, PHP ve MySQL kullanılarak geliştirilen bir otopark yönetim sistemidir.

🎯 Amaç; otoparklara gelen araçların giriş-çıkış işlemlerini takip edebilmek, çalışan ve yönetici rollerine göre sistemi
düzenleyebilmek ve ücretlendirmeleri otomatikleştirmektir.

------------------------------------------------------------------------

⚙️ Temel Özellikler

🔐 Giriş Sistemi ve Yetkilendirme:

👥 Kullanıcılar sisteme Admin veya Çalışan olarak giriş yapabilir.

🛡️ Admin olarak giriş yapabilmek için kullanıcının supervisor yetkisine sahip olması gerekir.

------------------------------------------------------------------------

🚘 Araç Giriş ve Çıkış İşlemleri:

📝 Çalışanlar, gelen araçların plaka, müşteri adı, telefon, blok ve park yeri bilgilerini girerek kayıt oluşturur.

⏳ Çıkış sırasında sistem, aracın otoparkta kaldığı süreye göre otomatik ücret hesaplaması yapar.

💰 Ücret hesaplamasında tanımlı süre aralıkları ve ücretler baz alınır.

------------------------------------------------------------------------

🧾 PDF Fiş Oluşturma - TCPDF:

📄 Araç çıkışı tamamlandığında müşteriye verilecek fiş, TCPDF kütüphanesiyle otomatik olarak PDF şeklinde oluşturulur.

🧾 PDF dosyasında; plaka, giriş-çıkış saatleri, kalınan süre ve toplam ücret bilgisi yer alır.

------------------------------------------------------------------------

🔄 Dinamik Park Yeri Seçimi - AJAX:

🧠 Araç kayıt formunda blok seçildiğinde, o bloğa ait park yerleri
AJAX ile dinamik olarak yüklenir.

⚡ Bu sayede kullanıcı sayfayı yenilemeden ilgili park yerlerini
hızlıca görebilir.

------------------------------------------------------------------------

🛠️ Admin Panel Özellikleri:

👤 Yeni çalışan kullanıcıları ekleyebilir.

🕒 Süre ve ücret aralıklarını düzenleyebilir.

🔒 Sisteme sadece yetkili kullanıcılar erişebilir.

♻️ Güncellenen veriler anında sistemde geçerli olur.

------------------------------------------------------------------------

🧰 Kullanılan Teknolojiler:

-   🐘 PHP
-   🌐 HTML/CSS, JavaScript
-   🛢️ MySQL
-   🎨 Bootstrap 5, Google Fonts (Arayüz tasarımı)
-   🔄 AJAX (Dinamik veri işlemleri)
-   📄 TCPDF (PDF oluşturma)

###  📄 Lisans
Bu proje MIT Lisansı altında lisanslanmıştır – ayrıntılar için [LICENSE](./LICENSE) dosyasına bakın.
