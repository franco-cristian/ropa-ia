<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Productos originales
            [
                'name' => 'Campera Impermeable Northface',
                'category' => 'Abrigos',
                'price' => 120000.00,
                'stock' => 5,
                'long_description' => 'Ideal para climas lluviosos y húmedos. Tela GORE-TEX que repele el agua y mantiene el calor corporal.'
            ],
            [
                'name' => 'Remera de Algodón Pima',
                'category' => 'Remeras',
                'price' => 45000.50,
                'stock' => 20,
                'long_description' => 'Suave al tacto y muy fresca. Perfecta para días de más de 30 grados.'
            ],
            [
                'name' => 'Short de Lino',
                'category' => 'Pantalones',
                'price' => 65000.00,
                'stock' => 15,
                'long_description' => 'El lino es la mejor opción para la humedad alta. Permite que la piel respire y se seca rápidamente.'
            ],
            [
                'name' => 'Buzo de Friza Invisible',
                'category' => 'Abrigos',
                'price' => 89900.00,
                'stock' => 0,
                'long_description' => 'Un abrigo clásico para el frío seco, pero actualmente sin stock.'
            ],

            // Abrigos de Invierno (20 productos)
            [
                'name' => 'Campera de Pluma Hombre - The North Face',
                'category' => 'Abrigos',
                'price' => 185000.00,
                'stock' => 8,
                'long_description' => 'Abrigo de pluma natural para temperaturas bajo cero. Ideal para invierno extremo.'
            ],
            [
                'name' => 'Parka Impermeable Mujer - Columbia',
                'category' => 'Abrigos',
                'price' => 145000.00,
                'stock' => 12,
                'long_description' => 'Parka con tecnología Omni-Heat reflectiva. Perfecta para nieve y lluvia.'
            ],
            [
                'name' => 'Abrigo de Lana Clásico Hombre',
                'category' => 'Abrigos',
                'price' => 98000.00,
                'stock' => 6,
                'long_description' => 'Abrigo de lana merino para ocasiones formales en climas fríos.'
            ],
            [
                'name' => 'Campera Softshell Unisex - Salomon',
                'category' => 'Abrigos',
                'price' => 75000.00,
                'stock' => 15,
                'long_description' => 'Ideal para deportes de invierno. Resistente al viento y transpirable.'
            ],
            [
                'name' => 'Chaleco Polar Hombre - Patagonia',
                'category' => 'Abrigos',
                'price' => 68000.00,
                'stock' => 10,
                'long_description' => 'Chaleco térmico para capas intermedias. Perfecto bajo otras prendas.'
            ],
            [
                'name' => 'Tapado de Invierno Mujer - Zara',
                'category' => 'Abrigos',
                'price' => 89000.00,
                'stock' => 7,
                'long_description' => 'Tapado largo de invierno para temperaturas bajo cero.'
            ],
            [
                'name' => 'Rompevientos Deportivo Unisex',
                'category' => 'Abrigos',
                'price' => 55000.00,
                'stock' => 20,
                'long_description' => 'Liviano y compacto. Ideal para llevar de reserva en días variables.'
            ],
            [
                'name' => 'Campera Ski Hombre - Atomic',
                'category' => 'Abrigos',
                'price' => 165000.00,
                'stock' => 4,
                'long_description' => 'Tecnología especial para deportes de nieve. Impermeable y térmica.'
            ],
            [
                'name' => 'Cazadora de Cuero Mujer',
                'category' => 'Abrigos',
                'price' => 125000.00,
                'stock' => 9,
                'long_description' => 'Cuero genuino. Abriga sin pesar demasiado. Ideal para otoño/invierno.'
            ],
            [
                'name' => 'Parka Larga con Cinturón Mujer',
                'category' => 'Abrigos',
                'price' => 135000.00,
                'stock' => 5,
                'long_description' => 'Parka hasta la rodilla con cinturón ajustable. Muy abrigada.'
            ],
            [
                'name' => 'Campera Militar Hombre',
                'category' => 'Abrigos',
                'price' => 72000.00,
                'stock' => 11,
                'long_description' => 'Estilo militar. Resistente al viento y agua.'
            ],
            [
                'name' => 'Abrigo de Pelo Mujer',
                'category' => 'Abrigos',
                'price' => 110000.00,
                'stock' => 3,
                'long_description' => 'Abrigo de pelo sintético. Muy cálido y fashion.'
            ],
            [
                'name' => 'Chaqueta Acolchada Unisex',
                'category' => 'Abrigos',
                'price' => 82000.00,
                'stock' => 14,
                'long_description' => 'Relleno sintético. Ideal para ciudad en invierno.'
            ],
            [
                'name' => 'Campera de Jeans Hombre',
                'category' => 'Abrigos',
                'price' => 58000.00,
                'stock' => 18,
                'long_description' => 'Clásica campera de jeans. Perfecta para templado/frío.'
            ],
            [
                'name' => 'Tapado de Lana Mujer',
                'category' => 'Abrigos',
                'price' => 95000.00,
                'stock' => 6,
                'long_description' => 'Lana pura. Elegante y abrigado.'
            ],
            [
                'name' => 'Rompevientos Packable Hombre',
                'category' => 'Abrigos',
                'price' => 48000.00,
                'stock' => 22,
                'long_description' => 'Se guarda en su propio bolsillo. Práctico para imprevistos.'
            ],
            [
                'name' => 'Campera Bomber Mujer',
                'category' => 'Abrigos',
                'price' => 67000.00,
                'stock' => 13,
                'long_description' => 'Estilo bomber. Cálida y moderna.'
            ],
            [
                'name' => 'Parka con Capucha Desmontable',
                'category' => 'Abrigos',
                'price' => 142000.00,
                'stock' => 7,
                'long_description' => 'Capucha de piel sintética desmontable. Máxima protección.'
            ],
            [
                'name' => 'Chaqueta de Trail Running',
                'category' => 'Abrigos',
                'price' => 89000.00,
                'stock' => 9,
                'long_description' => 'Ultraliviana para deporte en clima frío.'
            ],

            // Remeras y Camisas (20 productos)
            [
                'name' => 'Remera Algodón Manga Corta Hombre',
                'category' => 'Remeras',
                'price' => 15000.00,
                'stock' => 50,
                'long_description' => 'Algodón 100% respirable. Ideal para calor extremo.'
            ],
            [
                'name' => 'Blusa de Seda Mujer',
                'category' => 'Remeras',
                'price' => 45000.00,
                'stock' => 15,
                'long_description' => 'Seda natural. Fresca y elegante para verano.'
            ],
            [
                'name' => 'Remera Térmica Manga Larga',
                'category' => 'Remeras',
                'price' => 28000.00,
                'stock' => 25,
                'long_description' => 'Base layer para invierno. Mantiene el calor corporal.'
            ],
            [
                'name' => 'Camisa Lino Hombre',
                'category' => 'Camisas',
                'price' => 38000.00,
                'stock' => 30,
                'long_description' => 'Lino natural. Perfecta para humedad y calor.'
            ],
            [
                'name' => 'Top Deportivo Mujer',
                'category' => 'Remeras',
                'price' => 22000.00,
                'stock' => 35,
                'long_description' => 'Tecnología dry-fit. Ideal para ejercicio en verano.'
            ],
            [
                'name' => 'Camisa Oxford Hombre',
                'category' => 'Camisas',
                'price' => 32000.00,
                'stock' => 28,
                'long_description' => 'Algodón oxford. Versátil para todo clima.'
            ],
            [
                'name' => 'Blusa Manga Corta Mujer',
                'category' => 'Remeras',
                'price' => 19000.00,
                'stock' => 40,
                'long_description' => 'Tela liviana. Perfecta para primavera/verano.'
            ],
            [
                'name' => 'Remera UV Protection',
                'category' => 'Remeras',
                'price' => 35000.00,
                'stock' => 20,
                'long_description' => 'Protección solar UPF 50+. Ideal para playa y deportes.'
            ],
            [
                'name' => 'Camisa Vestir Hombre',
                'category' => 'Camisas',
                'price' => 42000.00,
                'stock' => 22,
                'long_description' => 'Algodón peinado. Formal y cómoda.'
            ],
            [
                'name' => 'Remera Cuello V Hombre',
                'category' => 'Remeras',
                'price' => 12000.00,
                'stock' => 60,
                'long_description' => 'Básico para calor. Algodón suave.'
            ],
            [
                'name' => 'Blusa Manga Larga Mujer',
                'category' => 'Remeras',
                'price' => 27000.00,
                'stock' => 18,
                'long_description' => 'Seda sintética. Elegante para oficina.'
            ],
            [
                'name' => 'Camisa Flannel Hombre',
                'category' => 'Camisas',
                'price' => 36000.00,
                'stock' => 16,
                'long_description' => 'Franela cálida. Otoño/invierno.'
            ],
            [
                'name' => 'Remera Dry-Fit Running',
                'category' => 'Remeras',
                'price' => 29000.00,
                'stock' => 32,
                'long_description' => 'Tecnología de secado rápido. Deporte intenso.'
            ],
            [
                'name' => 'Camisa Popelina Mujer',
                'category' => 'Camisas',
                'price' => 31000.00,
                'stock' => 24,
                'long_description' => 'Tela fresca. Ideal para calor húmedo.'
            ],
            [
                'name' => 'Remera Térmica Térmica Base Layer',
                'category' => 'Remeras',
                'price' => 33000.00,
                'stock' => 14,
                'long_description' => 'Merino wool. Calor sin volumen.'
            ],
            [
                'name' => 'Camisa Casual Hombre',
                'category' => 'Camisas',
                'price' => 25000.00,
                'stock' => 38,
                'long_description' => 'Algodón cómodo. Uso diario.'
            ],
            [
                'name' => 'Blusa Encaje Mujer',
                'category' => 'Remeras',
                'price' => 41000.00,
                'stock' => 12,
                'long_description' => 'Encaje delicado. Ocasiones especiales.'
            ],
            [
                'name' => 'Remera Polo Hombre',
                'category' => 'Remeras',
                'price' => 23000.00,
                'stock' => 45,
                'long_description' => 'Pique de algodón. Semi-formal.'
            ],
            [
                'name' => 'Camisa Seda Mujer',
                'category' => 'Camisas',
                'price' => 52000.00,
                'stock' => 8,
                'long_description' => 'Seda natural. Lujo y comodidad.'
            ],
            [
                'name' => 'Remera Manga 3/4 Unisex',
                'category' => 'Remeras',
                'price' => 18000.00,
                'stock' => 55,
                'long_description' => 'Versión intermedia entre manga corta y larga.'
            ],

            // Pantalones y Shorts (20 productos)
            [
                'name' => 'Jeans Slim Fit Hombre',
                'category' => 'Pantalones',
                'price' => 42000.00,
                'stock' => 35,
                'long_description' => 'Algodón elastano. Cómodos para todo clima.'
            ],
            [
                'name' => 'Short Denim Mujer',
                'category' => 'Shorts',
                'price' => 28000.00,
                'stock' => 40,
                'long_description' => 'Jean corto. Ideal verano.'
            ],
            [
                'name' => 'Pantalón Cargo Hombre',
                'category' => 'Pantalones',
                'price' => 38000.00,
                'stock' => 25,
                'long_description' => 'Múltiples bolsillos. Práctico.'
            ],
            [
                'name' => 'Short Deportivo Unisex',
                'category' => 'Shorts',
                'price' => 22000.00,
                'stock' => 60,
                'long_description' => 'Secado rápido. Deporte y playa.'
            ],
            [
                'name' => 'Pantalón Vestir Mujer',
                'category' => 'Pantalones',
                'price' => 45000.00,
                'stock' => 18,
                'long_description' => 'Corte elegante. Oficina.'
            ],
            [
                'name' => 'Bermuda Hombre',
                'category' => 'Shorts',
                'price' => 32000.00,
                'stock' => 32,
                'long_description' => 'Longitud rodilla. Casual.'
            ],
            [
                'name' => 'Legging Deportivo Mujer',
                'category' => 'Pantalones',
                'price' => 29000.00,
                'stock' => 48,
                'long_description' => 'Elástico. Yoga y ejercicio.'
            ],
            [
                'name' => 'Pantalón Trekking Hombre',
                'category' => 'Pantalones',
                'price' => 67000.00,
                'stock' => 15,
                'long_description' => 'Impermeable y transpirable. Montaña.'
            ],
            [
                'name' => 'Short Lino Mujer',
                'category' => 'Shorts',
                'price' => 31000.00,
                'stock' => 28,
                'long_description' => 'Lino natural. Fresco.'
            ],
            [
                'name' => 'Pantalón Chino Hombre',
                'category' => 'Pantalones',
                'price' => 35000.00,
                'stock' => 42,
                'long_description' => 'Gabardina. Semi-formal.'
            ],
            [
                'name' => 'Short Caballero Mujer',
                'category' => 'Shorts',
                'price' => 26000.00,
                'stock' => 36,
                'long_description' => 'Corte alto. Moda.'
            ],
            [
                'name' => 'Pantalón Jogger Unisex',
                'category' => 'Pantalones',
                'price' => 33000.00,
                'stock' => 52,
                'long_description' => 'Cómodo. Uso diario.'
            ],
            [
                'name' => 'Short Baño Hombre',
                'category' => 'Shorts',
                'price' => 19000.00,
                'stock' => 65,
                'long_description' => 'Secado rápido. Playa/pileta.'
            ],
            [
                'name' => 'Pantalón Sastrería Mujer',
                'category' => 'Pantalones',
                'price' => 48000.00,
                'stock' => 22,
                'long_description' => 'Elegante. Trabajo.'
            ],
            [
                'name' => 'Bermuda Surf Hombre',
                'category' => 'Shorts',
                'price' => 27000.00,
                'stock' => 44,
                'long_description' => 'Resistente agua. Deporte.'
            ],
            [
                'name' => 'Pantalón Thermal Invierno',
                'category' => 'Pantalones',
                'price' => 54000.00,
                'stock' => 12,
                'long_description' => 'Interior polar. Frío extremo.'
            ],
            [
                'name' => 'Short Yoga Mujer',
                'category' => 'Shorts',
                'price' => 21000.00,
                'stock' => 58,
                'long_description' => 'Elástico. Ejercicio.'
            ],
            [
                'name' => 'Pantalón Capri Mujer',
                'category' => 'Pantalones',
                'price' => 37000.00,
                'stock' => 26,
                'long_description' => 'Tobillo. Temporada media.'
            ],
            [
                'name' => 'Short Cargo Hombre',
                'category' => 'Shorts',
                'price' => 30000.00,
                'stock' => 38,
                'long_description' => 'Bolsillos. Práctico.'
            ],
            [
                'name' => 'Pantalón Lino Hombre',
                'category' => 'Pantalones',
                'price' => 41000.00,
                'stock' => 20,
                'long_description' => 'Lino. Calor húmedo.'
            ],

            // Calzado (15 productos)
            [
                'name' => 'Zapatillas Running Hombre - Nike',
                'category' => 'Calzado',
                'price' => 85000.00,
                'stock' => 25,
                'long_description' => 'Amortiguación reactiva. Deporte performance.'
            ],
            [
                'name' => 'Botas Invierno Mujer - Timberland',
                'category' => 'Calzado',
                'price' => 125000.00,
                'stock' => 8,
                'long_description' => 'Impermeables. Nieve y lluvia.'
            ],
            [
                'name' => 'Zapatos Vestir Hombre',
                'category' => 'Calzado',
                'price' => 68000.00,
                'stock' => 15,
                'long_description' => 'Cuero genuino. Formal.'
            ],
            [
                'name' => 'Sandalias Playa Mujer',
                'category' => 'Calzado',
                'price' => 32000.00,
                'stock' => 40,
                'long_description' => 'Resistentes agua. Verano.'
            ],
            [
                'name' => 'Zapatillas Trail Running',
                'category' => 'Calzado',
                'price' => 92000.00,
                'stock' => 12,
                'long_description' => 'Suela agarre. Montaña.'
            ],
            [
                'name' => 'Alpargatas Unisex',
                'category' => 'Calzado',
                'price' => 18000.00,
                'stock' => 60,
                'long_description' => 'Yute. Casual verano.'
            ],
            [
                'name' => 'Botines Cuero Mujer',
                'category' => 'Calzado',
                'price' => 78000.00,
                'stock' => 18,
                'long_description' => 'Cuero. Otoño/invierno.'
            ],
            [
                'name' => 'Zapatillas Casual Hombre',
                'category' => 'Calzado',
                'price' => 55000.00,
                'stock' => 32,
                'long_description' => 'Estilo urbano. Diario.'
            ],
            [
                'name' => 'Sandalias Trekking',
                'category' => 'Calzado',
                'price' => 45000.00,
                'stock' => 22,
                'long_description' => 'Soporte. Senderismo acuático.'
            ],
            [
                'name' => 'Zapatos Oxford Mujer',
                'category' => 'Calzado',
                'price' => 72000.00,
                'stock' => 14,
                'long_description' => 'Elegantes. Oficina.'
            ],
            [
                'name' => 'Zuecos Invierno',
                'category' => 'Calzado',
                'price' => 38000.00,
                'stock' => 28,
                'long_description' => 'Interior peludo. Frío.'
            ],
            [
                'name' => 'Zapatillas Basketball',
                'category' => 'Calzado',
                'price' => 89000.00,
                'stock' => 10,
                'long_description' => 'Soporte tobillo. Deporte.'
            ],
            [
                'name' => 'Mocasines Hombre',
                'category' => 'Calzado',
                'price' => 61000.00,
                'stock' => 20,
                'long_description' => 'Cuero. Casual elegante.'
            ],
            [
                'name' => 'Sandalias Tacon Mujer',
                'category' => 'Calzado',
                'price' => 54000.00,
                'stock' => 16,
                'long_description' => 'Noche. Verano.'
            ],
            [
                'name' => 'Zapatillas Ortholite',
                'category' => 'Calzado',
                'price' => 67000.00,
                'stock' => 24,
                'long_description' => 'Plantilla comfort. Caminata.'
            ],

            // Accesorios (15 productos)
            [
                'name' => 'Gorra Baseball Hombre',
                'category' => 'Accesorios',
                'price' => 15000.00,
                'stock' => 45,
                'long_description' => 'Protección solar. Verano.'
            ],
            [
                'name' => 'Bufanda Lana Mujer',
                'category' => 'Accesorios',
                'price' => 22000.00,
                'stock' => 30,
                'long_description' => 'Lana merino. Invierno.'
            ],
            [
                'name' => 'Guantes Ski The North Face',
                'category' => 'Accesorios',
                'price' => 45000.00,
                'stock' => 12,
                'long_description' => 'Impermeables. Nieve.'
            ],
            [
                'name' => 'Lentes Sol Polarized',
                'category' => 'Accesorios',
                'price' => 38000.00,
                'stock' => 25,
                'long_description' => 'Protección UV. Verano.'
            ],
            [
                'name' => 'Sombrero Panamá Hombre',
                'category' => 'Accesorios',
                'price' => 28000.00,
                'stock' => 18,
                'long_description' => 'Paja. Calor extremo.'
            ],
            [
                'name' => 'Medias Térmicas Invierno',
                'category' => 'Accesorios',
                'price' => 12000.00,
                'stock' => 60,
                'long_description' => 'Lana. Frío.'
            ],
            [
                'name' => 'Pañuelo Seda Mujer',
                'category' => 'Accesorios',
                'price' => 16000.00,
                'stock' => 35,
                'long_description' => 'Accesorio. Primavera.'
            ],
            [
                'name' => 'Gorra Visera Golf',
                'category' => 'Accesorios',
                'price' => 19000.00,
                'stock' => 28,
                'long_description' => 'Protección facial. Deporte.'
            ],
            [
                'name' => 'Braga Cuello Polar',
                'category' => 'Accesorios',
                'price' => 14000.00,
                'stock' => 42,
                'long_description' => 'Protección viento. Invierno.'
            ],
            [
                'name' => 'Bandana Deportiva',
                'category' => 'Accesorios',
                'price' => 8000.00,
                'stock' => 75,
                'long_description' => 'Multiuso. Deporte.'
            ],
            [
                'name' => 'Gorro Lana Invierno',
                'category' => 'Accesorios',
                'price' => 17000.00,
                'stock' => 38,
                'long_description' => 'Lana. Frío.'
            ],
            [
                'name' => 'Cinturón Cuero Hombre',
                'category' => 'Accesorios',
                'price' => 25000.00,
                'stock' => 22,
                'long_description' => 'Cuero genuino. Formal.'
            ],
            [
                'name' => 'Bolso Deportivo Impermeable',
                'category' => 'Accesorios',
                'price' => 55000.00,
                'stock' => 15,
                'long_description' => 'Lluvia. Deporte.'
            ],
            [
                'name' => 'Paraguas Compacto',
                'category' => 'Accesorios',
                'price' => 21000.00,
                'stock' => 50,
                'long_description' => 'Protección lluvia. Práctico.'
            ],
            [
                'name' => 'Guantes Touchscreen',
                'category' => 'Accesorios',
                'price' => 18000.00,
                'stock' => 32,
                'long_description' => 'Permite uso smartphone. Invierno.'
            ],

            // Ropa Interior (6 productos)
            [
                'name' => 'Boxer Algodón Hombre',
                'category' => 'Ropa Interior',
                'price' => 5000.00,
                'stock' => 100,
                'long_description' => 'Algodón respirable. Diario.'
            ],
            [
                'name' => 'Calza Térmica Mujer',
                'category' => 'Ropa Interior',
                'price' => 18000.00,
                'stock' => 25,
                'long_description' => 'Base layer. Invierno.'
            ],
            [
                'name' => 'Medias Deportivas',
                'category' => 'Ropa Interior',
                'price' => 6000.00,
                'stock' => 80,
                'long_description' => 'Tecnología dry-fit. Deporte.'
            ],
            [
                'name' => 'Top Deportivo Mujer',
                'category' => 'Ropa Interior',
                'price' => 22000.00,
                'stock' => 35,
                'long_description' => 'Soporte. Ejercicio.'
            ],
            [
                'name' => 'Slip Bamboo Hombre',
                'category' => 'Ropa Interior',
                'price' => 7000.00,
                'stock' => 65,
                'long_description' => 'Bambú antibacterial. Fresco.'
            ],
            [
                'name' => 'Body Térmico Invierno',
                'category' => 'Ropa Interior',
                'price' => 25000.00,
                'stock' => 18,
                'long_description' => 'Cuerpo completo. Frío extremo.'
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}