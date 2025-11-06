// ✅ Import Bootstrap CSS
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

// ✅ Import Livewire/Alpine base bootstrap file (usually sets axios + Echo)
import './bootstrap';

// ✅ Import Bootstrap JS (very important!)
import 'bootstrap';

// ✅ (Optional but recommended) Alpine.js for Livewire interactivity
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
