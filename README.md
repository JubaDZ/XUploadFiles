# سكربت رفع الملفات
 :+1: السكربت المثالي لرفع الملفات

# مميزات السكربت
- متعدد اللغات
- الاعتماد بشكل كلي على تقنية ajax
- تعدد الصفحات باستخدام تقنية ajax ما يسمح بتسريع التصفح
- متعدد الاوان والاشكال وسهولة تركيب اي ستايل
- اعتماده على مكتبة Bootstrap مما يجعله متجاوب مع كل المتصفحات والاجهزة
- امكانية تسجيل الدخول واضافة مستخدمين جدد
- متعدد الرفع مع ( شريط التقدم )
- لوحة تحكم متقدمة
- بحث متقدم للملفات ( عبر اسم المستخدم المجلد التاريخ ..)
- قواعد البيانات Mysqli
- حماية جيدة من ( البوت والشل و xss) 
- دعم للهواتف والاجهزة اللوحية
- الحذف المتعدد
- امكانية اضافة تعليق
- احصائيات متقدمة ( البلد و المرجع والمتصفح والتاريخ )
- حذف الملفات الخاملة
- نظام الخطط مع التحكم الكامل
- حماية الملفات بكلمة مرور
- نظام مصغرات للصور
- دعم الملفات الكبيرة تحميل ورفع اكثر من 4 جيقا
- وضع حدود للتحميل
- دعم المتصفح انترنت اكسبلورر 8

# اعدادات 
###### `config.php`
```php
define('dbhost','localhost'); 
define('dbuser','root'); 
define('dbpass',''); 
define('dbname','db_uploads'); 
//false-true
define('FooterInfo',false); // تمكين معلومات الرفع والحجم وعدد الملفات للجميع 
define('EnableLogo',false); // تمكين الشعار
define('UpdateBrowser',true); // ie8=< رسالة تنبيه في المتصفحات القديمة  
define('DirectoryChanged',false); // تنبيه عند حدوث تغيير في المسار
```
# طريقة التثبيت 
- قم بانشاء قاعدة بيانات باسم انت تختاره
- نتقل الى مسار التثبيت www.site.com/install/
- قم بتغيير معلومات الاستضافة ( اسم المستخدم وكلمة المرور والمضيف )
- قم باضافة ( اسم المستخدم وكلمة مرور وبريد ) الادمن
- قم بتغيير ما يجب تغييره كوصف الموقع واسم الموقع و ....

# صور 
###### `جوال`
![alt tag](https://raw.githubusercontent.com/JubaDZ/ScriptUploadFiles/master/Android-screencapture.png)

###### `لوحة الكترونية`
![alt tag](https://raw.githubusercontent.com/JubaDZ/ScriptUploadFiles/master/Tablets-screencapture.png)

###### `كمبيوتر محمول`
![alt tag](https://raw.githubusercontent.com/JubaDZ/ScriptUploadFiles/master/MacBook-screencapture.png)

# Download
##### [اضغط هنا لتحميل اخر نسخة](https://github.com/JubaDZ/ScriptUploadFiles/archive/master.zip)
