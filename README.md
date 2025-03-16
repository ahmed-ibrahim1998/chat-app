# مشروع Laravel 11 مع Jetstream

مرحبًا بك في هذا المشروع! هذا المشروع هو تطبيق ويب تم إنشاؤه باستخدام **Laravel 11** مع إضافة **Jetstream** لتوفير ميزات المصادقة وإدارة المستخدمين بسهولة. يستخدم المشروع **Livewire** كإطار عمل للواجهة الأمامية لتوفير تجربة تفاعلية دون الحاجة إلى JavaScript معقد.

## Basic Demo
Watch the explanatory video:  
[![Video Preview](preview_image_link)](https://vimeo.com/1066385189)

## نظرة عامة
- **الإصدار**: Laravel 11
- **المصادقة**: Jetstream مع Livewire
- **قاعدة البيانات**: MySQL أو SQLite (قابل للتخصيص)
- **الواجهة الأمامية**: Tailwind CSS وLivewire
- **الغرض**: توفير نقطة انطلاق لتطبيق ويب حديث مع ميزات جاهزة مثل تسجيل الدخول، التسجيل، ولوحة التحكم.

---

## متطلبات النظام
لتشغيل هذا المشروع، ستحتاج إلى:
- **PHP**: 8.2 أو أحدث
- **Composer**: أحدث إصدار
- **Node.js و npm**: لتجميع الأصول
- **قاعدة بيانات**: MySQL، SQLite، أو أي قاعدة بيانات مدعومة من Laravel
- **Git**: لتنزيل المشروع من مستودع Git

### التحقق من المتطلبات
```bash
php -v          # يجب أن يكون 8.2 أو أحدث
composer -v     # تأكد من تحديث Composer
node -v         # تحقق من Node.js
npm -v          # تحقق من npm
git --version   # تحقق من Git


افتح الطرفية (Terminal) وانتقل إلى المجلد الذي تريد حفظ المشروع فيه:

cd /path/to/your/projects

انسخ المشروع من المستودع (استبدل <repository-url> برابط المستودع الخاص بك):

git clone <https://github.com/ahmed-ibrahim1998/chat-app> chat-app

انتقل إلى مجلد المشروع:

cd chat-app

قم بتثبيت حزم PHP باستخدام Composer:

composer install

قم بتثبيت حزم JavaScript باستخدام npm:

npm install && npm install

3. إعداد الملفات البيئية

cp .env.example .env

عدّل ملف .env لإعداد قاعدة البيانات:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chat-app
DB_USERNAME=root
DB_PASSWORD=your_password

قم بتوليد مفتاح التطبيق:

php artisan key:generate

شغل الـ migrations لإنشاء الجداول:

php artisan migrate

قم بتجميع ملفات CSS وJavaScript باستخدام Vite:

npm run dev

6. تشغيل المشروع

php artisan serve

افتح المتصفح واذهب إلى:

http://localhost:8000

7. اختبار المشروع

/register: لتسجيل مستخدم جديد.
/login: لتسجيل الدخول.
/dashboard: للوصول إلى لوحة التحكم (بعد تسجيل الدخول).
/chat: للوصول الي المحادثة.
