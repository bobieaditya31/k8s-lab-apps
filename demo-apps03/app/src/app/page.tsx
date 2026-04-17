'use client';

import { useState, useEffect } from 'react';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Coffee, MapPin, Clock, Phone, Instagram, Facebook, Menu, X } from 'lucide-react';

export default function BocilCoffeShop() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [activeSection, setActiveSection] = useState('home');

  const menuItems = [
    { id: 'home', label: 'Beranda' },
    { id: 'about', label: 'Tentang Kami' },
    { id: 'menu', label: 'Menu' },
    { id: 'gallery', label: 'Galeri' },
    { id: 'contact', label: 'Kontak' },
  ];

  const coffeeMenu = [
    { name: 'Kopi Susu Gula Aren', price: 'Rp 25.000', description: 'Signature coffee dengan gula aren asli' },
    { name: 'Butterscotch Coffee', price: 'Rp 28.000', description: 'Perpaduan manis butterscotch dengan espresso' },
    { name: 'Kopi Susu Pandan Aren', price: 'Rp 27.000', description: 'Aroma pandan yang unik dengan gula aren' },
    { name: 'Caramello', price: 'Rp 26.000', description: 'Caramel latte dengan sentuhan khusus' },
    { name: 'Hazel Caramel', price: 'Rp 29.000', description: 'Hazelnut dan caramel combination' },
    { name: 'Caramel Popcorn Latte', price: 'Rp 30.000', description: 'Popcorn caramel dengan kopi nikmat' },
  ];

  const foodMenu = [
    { name: 'Spaghetti Bolognese', price: 'Rp 35.000', description: 'Spaghetti dengan saus bolognese authentic' },
    { name: 'Rice Bowl Chicken Salted Egg', price: 'Rp 32.000', description: 'Nasi dengan ayam saus telur asin' },
    { name: 'Red Velvet Cake', price: 'Rp 28.000', description: 'Cake lembut dengan cream cheese' },
    { name: 'Lychee Yakult', price: 'Rp 22.000', description: 'Minuman segar dengan lychee dan yakult' },
  ];

  const galleryImages = [
    { id: 1, title: 'Interior Cozy', description: 'Suasana nyaman untuk bersantai' },
    { id: 2, title: 'Coffee Corner', description: 'Area kopi khusus dengan barista profesional' },
    { id: 3, title: 'Work Space', description: 'WiFi gratis dengan meja kerja luas' },
    { id: 4, title: 'Outdoor Area', description: 'Area outdoor dengan pemandangan asri' },
    { id: 5, title: 'Signature Drinks', description: 'Menu minuman khas kami' },
    { id: 6, title: 'Food Presentation', description: 'Makanan dengan penyajian cantik' },
  ];

  useEffect(() => {
    const handleScroll = () => {
      const sections = document.querySelectorAll('section[id]');
      const scrollPos = window.scrollY + 100;

      sections.forEach((section) => {
        const sectionTop = (section as HTMLElement).offsetTop;
        const sectionHeight = (section as HTMLElement).offsetHeight;

        if (scrollPos >= sectionTop && scrollPos < sectionTop + sectionHeight) {
          setActiveSection(section.id);
        }
      });
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const scrollToSection = (sectionId: string) => {
    const element = document.getElementById(sectionId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
      setIsMenuOpen(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-amber-50 via-orange-50 to-rose-50">
      {/* Navigation */}
      <nav className="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-lg border-b border-amber-200/50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex items-center justify-between h-16">
            <div className="flex items-center gap-2">
              <Coffee className="h-8 w-8 text-amber-600" />
              <span className="text-xl font-bold bg-gradient-to-r from-amber-700 to-orange-600 bg-clip-text text-transparent">
                Bocil Coffee
              </span>
            </div>

            {/* Desktop Menu */}
            <div className="hidden md:flex items-center gap-8">
              {menuItems.map((item) => (
                <button
                  key={item.id}
                  onClick={() => scrollToSection(item.id)}
                  className={`text-sm font-medium transition-colors duration-300 hover:text-amber-600 ${
                    activeSection === item.id ? 'text-amber-700 font-semibold' : 'text-gray-700'
                  }`}
                >
                  {item.label}
                </button>
              ))}
              <Button className="bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white px-6 rounded-full">
                Reservasi
              </Button>
            </div>

            {/* Mobile Menu Button */}
            <button
              onClick={() => setIsMenuOpen(!isMenuOpen)}
              className="md:hidden p-2 rounded-lg hover:bg-amber-100 transition-colors"
            >
              {isMenuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {isMenuOpen && (
          <div className="md:hidden bg-white/95 backdrop-blur-lg border-t border-amber-200/50">
            <div className="px-4 py-4 space-y-2">
              {menuItems.map((item) => (
                <button
                  key={item.id}
                  onClick={() => scrollToSection(item.id)}
                  className={`block w-full text-left px-4 py-2 rounded-lg transition-colors duration-300 ${
                    activeSection === item.id
                      ? 'bg-amber-100 text-amber-700 font-semibold'
                      : 'text-gray-700 hover:bg-amber-50'
                  }`}
                >
                  {item.label}
                </button>
              ))}
              <Button className="w-full mt-4 bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white">
                Reservasi
              </Button>
            </div>
          </div>
        )}
      </nav>

      {/* Hero Section */}
      <section id="home" className="pt-16">
        <div className="relative min-h-screen flex items-center justify-center overflow-hidden">
          <div className="absolute inset-0 bg-gradient-to-br from-amber-600/20 via-orange-500/20 to-rose-600/20" />
          <div className="absolute inset-0">
            <div className="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjEiIGZpbGw9IiNmZmZmZmYiIGZpbGwtb3BhY2l0eT0iMC4zIi8+PC9zdmc+')] opacity-50" />
          </div>

          <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-20">
            <div className="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-1000">
              <div className="inline-block px-4 py-2 bg-white/60 backdrop-blur-sm rounded-full border border-amber-300/50">
                <span className="text-sm font-medium text-amber-700">
                  ☕ Coffee • Kitchen • Space
                </span>
              </div>

              <h1 className="text-5xl sm:text-6xl lg:text-7xl font-bold text-gray-900 leading-tight">
                Every Moment Has Its
                <span className="block bg-gradient-to-r from-amber-600 via-orange-600 to-rose-600 bg-clip-text text-transparent">
                  Flavor
                </span>
              </h1>

              <p className="max-w-2xl mx-auto text-lg sm:text-xl text-gray-700 leading-relaxed">
                Nikmati suasana cozy dengan kopi berkualitas premium, makanan lezat, dan WiFi gratis
                untuk bekerja atau bersantai di Cibinong
              </p>

              <div className="flex flex-col sm:flex-row items-center justify-center gap-4">
                <Button
                  size="lg"
                  className="bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white px-8 py-6 text-lg rounded-full shadow-lg hover:shadow-xl transition-all duration-300"
                  onClick={() => scrollToSection('menu')}
                >
                  Lihat Menu
                </Button>
                <Button
                  size="lg"
                  variant="outline"
                  className="border-2 border-amber-600 text-amber-700 hover:bg-amber-50 px-8 py-6 text-lg rounded-full"
                  onClick={() => scrollToSection('contact')}
                >
                  Hubungi Kami
                </Button>
              </div>

              <div className="flex items-center justify-center gap-8 pt-8 text-gray-600">
                <div className="flex items-center gap-2">
                  <Clock className="h-5 w-5" />
                  <span className="text-sm">Buka Setiap Hari</span>
                </div>
                <div className="flex items-center gap-2">
                  <MapPin className="h-5 w-5" />
                  <span className="text-sm">Pakansari, Cibinong</span>
                </div>
              </div>
            </div>
          </div>

          <div className="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-amber-50 via-orange-50 to-transparent" />
        </div>
      </section>

      {/* About Section */}
      <section id="about" className="py-20 bg-white/50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
              Tentang
              <span className="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                {' '}Enthree
              </span>
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Lebih dari sekadar cafe, ini adalah tempat di setiap momen memiliki rasanya sendiri
            </p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                icon: <Coffee className="h-8 w-8" />,
                title: 'Kopi Premium',
                description: 'Biji kopi pilihan dengan teknik brewing terbaik untuk menghasilkan rasa yang sempurna',
              },
              {
                icon: <MapPin className="h-8 w-8" />,
                title: 'Suasana Cozy',
                description: 'Interior modern dengan sentuhan warm yang membuat Anda betah berlama-lama',
              },
              {
                icon: <Clock className="h-8 w-8" />,
                title: 'WiFi Gratis',
                description: 'Koneksi internet cepat untuk bekerja, belajar, atau sekadar berselancar',
              },
            ].map((feature, index) => (
              <Card
                key={index}
                className="group hover:shadow-2xl transition-all duration-300 border-amber-200/50 hover:border-amber-400 bg-white/80 backdrop-blur-sm"
              >
                <CardContent className="p-8">
                  <div className="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-amber-100 to-orange-100 rounded-2xl mb-6 group-hover:scale-110 transition-transform duration-300">
                    <div className="text-amber-600">
                      {feature.icon}
                    </div>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 mb-3">{feature.title}</h3>
                  <p className="text-gray-600 leading-relaxed">{feature.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Menu Section */}
      <section id="menu" className="py-20 bg-gradient-to-br from-amber-50/80 via-orange-50/80 to-rose-50/80">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
              Menu
              <span className="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                {' '}Kami
              </span>
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Pilihan kopi dan makanan terbaik untuk menemani momen Anda
            </p>
          </div>

          <div className="grid lg:grid-cols-2 gap-12">
            {/* Coffee Menu */}
            <div>
              <div className="flex items-center gap-3 mb-8">
                <Coffee className="h-6 w-6 text-amber-600" />
                <h3 className="text-2xl font-bold text-gray-900">Signature Coffee</h3>
              </div>
              <div className="space-y-4">
                {coffeeMenu.map((item, index) => (
                  <Card
                    key={index}
                    className="group hover:shadow-xl transition-all duration-300 border-amber-200/50 hover:border-amber-400 bg-white/80 backdrop-blur-sm"
                  >
                    <CardContent className="p-6">
                      <div className="flex justify-between items-start gap-4">
                        <div className="flex-1">
                          <h4 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-amber-700 transition-colors">
                            {item.name}
                          </h4>
                          <p className="text-sm text-gray-600">{item.description}</p>
                        </div>
                        <div className="text-right">
                          <span className="text-lg font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                            {item.price}
                          </span>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>

            {/* Food Menu */}
            <div>
              <div className="flex items-center gap-3 mb-8">
                <MapPin className="h-6 w-6 text-amber-600" />
                <h3 className="text-2xl font-bold text-gray-900">Makanan & Minuman</h3>
              </div>
              <div className="space-y-4">
                {foodMenu.map((item, index) => (
                  <Card
                    key={index}
                    className="group hover:shadow-xl transition-all duration-300 border-amber-200/50 hover:border-amber-400 bg-white/80 backdrop-blur-sm"
                  >
                    <CardContent className="p-6">
                      <div className="flex justify-between items-start gap-4">
                        <div className="flex-1">
                          <h4 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-amber-700 transition-colors">
                            {item.name}
                          </h4>
                          <p className="text-sm text-gray-600">{item.description}</p>
                        </div>
                        <div className="text-right">
                          <span className="text-lg font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                            {item.price}
                          </span>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                ))}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Gallery Section */}
      <section id="gallery" className="py-20 bg-white/50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
              Galeri
              <span className="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                {' '}Kami
              </span>
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Intip suasana Bocil Coffee melalui foto-foto berikut
            </p>
          </div>

          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {galleryImages.map((image, index) => (
              <Card
                key={image.id}
                className="group overflow-hidden hover:shadow-2xl transition-all duration-300 border-amber-200/50 bg-white/80 backdrop-blur-sm"
              >
                <div className="relative aspect-square bg-gradient-to-br from-amber-200 via-orange-200 to-rose-200 flex items-center justify-center">
                  <Coffee className="h-20 w-20 text-amber-600/50 group-hover:scale-110 transition-transform duration-500" />
                </div>
                <CardContent className="p-4">
                  <h3 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-amber-700 transition-colors">
                    {image.title}
                  </h3>
                  <p className="text-sm text-gray-600">{image.description}</p>
                </CardContent>
              </Card>
            ))}
          </div>
        </div>
      </section>

      {/* Contact Section */}
      <section id="contact" className="py-20 bg-gradient-to-br from-amber-50 via-orange-50 to-rose-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center mb-16">
            <h2 className="text-4xl sm:text-5xl font-bold text-gray-900 mb-4">
              Hubungi
              <span className="bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                {' '}Kami
              </span>
            </h2>
            <p className="text-lg text-gray-600 max-w-2xl mx-auto">
              Kami menantikan kedatangan Anda di Bocil Coffee
            </p>
          </div>

          <div className="grid md:grid-cols-2 gap-12">
            {/* Contact Info */}
            <div className="space-y-6">
              {[
                {
                  icon: <MapPin className="h-6 w-6" />,
                  title: 'Lokasi',
                  content: 'Jl. Alkinanah Pakansari, Cibinong, Kab. Bogor, Jawa Barat',
                },
                {
                  icon: <Phone className="h-6 w-6" />,
                  title: 'Telepon / WhatsApp',
                  content: '+62 819-9939-6347',
                },
                {
                  icon: <Clock className="h-6 w-6" />,
                  title: 'Jam Operasional',
                  content: 'Setiap Hari, 10:00 - 22:00 WIB',
                },
              ].map((item, index) => (
                <Card
                  key={index}
                  className="border-amber-200/50 bg-white/80 backdrop-blur-sm hover:shadow-lg transition-all duration-300"
                >
                  <CardContent className="p-6">
                    <div className="flex items-start gap-4">
                      <div className="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-amber-100 to-orange-100 rounded-xl text-amber-600 shrink-0">
                        {item.icon}
                      </div>
                      <div>
                        <h3 className="text-lg font-bold text-gray-900 mb-1">{item.title}</h3>
                        <p className="text-gray-600">{item.content}</p>
                      </div>
                    </div>
                  </CardContent>
                </Card>
              ))}

              {/* Social Media */}
              <div className="flex gap-4">
                <Button
                  variant="outline"
                  size="lg"
                  className="flex-1 gap-2 border-amber-600 text-amber-700 hover:bg-amber-50"
                >
                  <Instagram className="h-5 w-5" />
                  @enthreecoffee
                </Button>
                <Button
                  variant="outline"
                  size="lg"
                  className="flex-1 gap-2 border-amber-600 text-amber-700 hover:bg-amber-50"
                >
                  <Facebook className="h-5 w-5" />
                  Bocil Coffee
                </Button>
              </div>
            </div>

            {/* Reservation Form */}
            <Card className="border-amber-200/50 bg-white/80 backdrop-blur-sm">
              <CardContent className="p-8">
                <h3 className="text-2xl font-bold text-gray-900 mb-6">Reservasi Meja</h3>
                <form className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Nama Lengkap
                    </label>
                    <input
                      type="text"
                      className="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 bg-white/80"
                      placeholder="Masukkan nama Anda"
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Nomor WhatsApp
                    </label>
                    <input
                      type="tel"
                      className="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 bg-white/80"
                      placeholder="08xx-xxxx-xxxx"
                    />
                  </div>
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal
                      </label>
                      <input
                        type="date"
                        className="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 bg-white/80"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-2">
                        Jam
                      </label>
                      <input
                        type="time"
                        className="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 bg-white/80"
                      />
                    </div>
                  </div>
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">
                      Jumlah Orang
                    </label>
                    <select className="w-full px-4 py-3 rounded-lg border border-amber-200 focus:border-amber-500 focus:ring-2 focus:ring-amber-200 transition-all duration-300 bg-white/80">
                      <option value="">Pilih jumlah orang</option>
                      {[1, 2, 3, 4, 5, 6, 7, 8].map((num) => (
                        <option key={num} value={num}>{num} Orang</option>
                      ))}
                      <option value="more">Lebih dari 8 Orang</option>
                    </select>
                  </div>
                  <Button
                    type="submit"
                    className="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white py-6 text-lg rounded-lg shadow-lg hover:shadow-xl transition-all duration-300"
                  >
                    Kirim Reservasi
                  </Button>
                </form>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-gray-300">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          <div className="grid md:grid-cols-4 gap-8 mb-8">
            <div className="md:col-span-2">
              <div className="flex items-center gap-2 mb-4">
                <Coffee className="h-8 w-8 text-amber-500" />
                <span className="text-2xl font-bold text-white">
                  Bocil Coffee
                </span>
              </div>
              <p className="text-gray-400 mb-4">
                Every Moment has its Flavor. Tempat terbaik untuk menikmati kopi premium,
                makanan lezat, dan suasana yang cozy di Cibinong.
              </p>
              <div className="flex gap-4">
                <Button
                  variant="ghost"
                  size="icon"
                  className="text-gray-400 hover:text-amber-500 hover:bg-amber-500/10"
                >
                  <Instagram className="h-5 w-5" />
                </Button>
                <Button
                  variant="ghost"
                  size="icon"
                  className="text-gray-400 hover:text-amber-500 hover:bg-amber-500/10"
                >
                  <Facebook className="h-5 w-5" />
                </Button>
              </div>
            </div>

            <div>
              <h3 className="text-lg font-bold text-white mb-4">Jam Operasional</h3>
              <ul className="space-y-2 text-gray-400">
                <li>Senin - Jumat</li>
                <li className="text-amber-500">10:00 - 22:00 WIB</li>
                <li className="mt-4">Sabtu - Minggu</li>
                <li className="text-amber-500">10:00 - 23:00 WIB</li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-bold text-white mb-4">Hubungi Kami</h3>
              <ul className="space-y-3 text-gray-400">
                <li className="flex items-start gap-2">
                  <MapPin className="h-5 w-5 shrink-0 mt-0.5 text-amber-500" />
                  <span>Jl. Alkinanah Pakansari, Cibinong, Bogor</span>
                </li>
                <li className="flex items-center gap-2">
                  <Phone className="h-5 w-5 shrink-0 text-amber-500" />
                  <span>+62 819-9939-6347</span>
                </li>
              </ul>
            </div>
          </div>

          <div className="border-t border-gray-800 pt-8 text-center text-gray-400">
            <p>&copy; {new Date().getFullYear()} Bocil Coffee & Kitchen. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  );
}