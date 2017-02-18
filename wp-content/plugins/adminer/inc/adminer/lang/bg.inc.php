<?php
$translations = array(
	// label for database system selection (MySQL, SQLite, ...)
	'System' => 'Система',
	'Server' => 'Сървър',
	'Username' => 'Потребител',
	'Password' => 'Парола',
	'Permanent login' => 'Запаметяване',
	'Login' => 'Вход',
	'Logout' => 'Изход',
	'Logged as: %s' => 'Текущ потребител: %s',
	'Logout successful.' => 'Излизането е успешно.',
	'Invalid credentials.' => 'Невалидни потребителски данни.',
	'Too many unsuccessful logins, try again in %d minute(s).' => array('Прекалено много неуспешни опити за вход, опитайте пак след %d минута.', 'Прекалено много неуспешни опити за вход, опитайте пак след %d минути.'),
	'Master password expired. <a href="https://www.adminer.org/en/extension/" target="_blank">Implement</a> %s method to make it permanent.' => 'Главната парола вече е невалидна. <a href="https://www.adminer.org/en/extension/" target="_blank">Изберете</a> %s метод, за да я направите постоянна.',
	'Language' => 'Език',
	'Invalid CSRF token. Send the form again.' => 'Невалиден шифроващ ключ. Попълнете и изпратете формуляра отново.',
	'If you did not send this request from Adminer then close this page.' => 'Ако не сте изпратили тази заявка през Adminer, затворете тази страница.',
	'No extension' => 'Няма разширение',
	'None of the supported PHP extensions (%s) are available.' => 'Никое от поддържаните PHP разширения (%s) не е налично.',
	'Session support must be enabled.' => 'Поддръжката на сесии трябва да е разрешена.',
	'Session expired, please login again.' => 'Сесията е изтекла; моля, влезте отново.',
	'%s version: %s through PHP extension %s' => '%s версия: %s през PHP разширение %s',
	'Refresh' => 'Обновяване',
	
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	
	'Privileges' => 'Права',
	'Create user' => 'Създаване на потребител',
	'User has been dropped.' => 'Потребителя беше премахнат.',
	'User has been altered.' => 'Потребителя беше променен.',
	'User has been created.' => 'Потребителя беше създаден.',
	'Hashed' => 'Хеширан',
	'Column' => 'Колона',
	'Routine' => 'Процедура',
	'Grant' => 'Осигуряване',
	'Revoke' => 'Отнемане',
	
	'Process list' => 'Списък с процеси',
	'%d process(es) have been killed.' => array('%d процес беше прекъснат.', '%d процеса бяха прекъснати.'),
	'Kill' => 'Прекъсване',
	
	'Variables' => 'Променливи',
	'Status' => 'Състояние',
	
	'SQL command' => 'SQL команда',
	'%d query(s) executed OK.' => array('%d заявка е изпълнена.', '%d заявки са изпълнени.'),
	'Query executed OK, %d row(s) affected.' => array('Заявката е изпълнена, %d ред е засегнат.', 'Заявката е изпълнена, %d редове са засегнати.'),
	'No commands to execute.' => 'Няма команди за изпълнение.',
	'Error in query' => 'Грешка в заявката',
	'Execute' => 'Изпълнение',
	'Stop on error' => 'Спиране при грешка',
	'Show only errors' => 'Показване само на грешките',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Хронология',
	'Clear' => 'Изчистване',
	'Edit all' => 'Редактиране на всички',
	
	'File upload' => 'Прикачване на файл',
	'From server' => 'От сървър',
	'Webserver file %s' => 'Сървърен файл %s',
	'Run file' => 'Изпълнение на файл',
	'File does not exist.' => 'Файлът не съществува.',
	'File uploads are disabled.' => 'Прикачването на файлове е забранено.',
	'Unable to upload a file.' => 'Неуспешно прикачване на файл.',
	'Maximum allowed file size is %sB.' => 'Максимално разрешената големина на файл е %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Изпратени са прекалено много данни. Намалете обема на данните или увеличете %s управляващата директива.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Можете да прикачите голям SQL файл чрез FTP и да го импортирате от сървъра.',
	'You are offline.' => 'Вие сте офлайн.',
	
	'Export' => 'Експорт',
	'Output' => 'Резултат',
	'open' => 'показване',
	'save' => 'запис',
	'Format' => 'Формат',
	'Data' => 'Данни',
	
	'Database' => 'База данни',
	'database' => 'база данни',
	'Use' => 'Избор',
	'Select database' => 'Избор на база данни',
	'Invalid database.' => 'Невалидна база данни.',
	'Create new database' => 'Нова база данни',
	'Database has been dropped.' => 'Базата данни беше премахната.',
	'Databases have been dropped.' => 'Базите данни бяха премехнати.',
	'Database has been created.' => 'Базата данни беше създадена.',
	'Database has been renamed.' => 'Базата данни беше преименувана.',
	'Database has been altered.' => 'Базата данни беше променена.',
	'Alter database' => 'Промяна на база данни',
	'Create database' => 'Създаване на база данни',
	'Database schema' => 'Схема на базата данни',
	
	// link to current database schema layout
	'Permanent link' => 'Постоянна препратка',
	
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	'Engine' => 'Система',
	'Collation' => 'Кодировка',
	'Data Length' => 'Големина на данните',
	'Index Length' => 'Големина на индекса',
	'Data Free' => 'Свободно място',
	'Rows' => 'Редове',
	'%d in total' => '%d всичко',
	'Analyze' => 'Анализиране',
	'Optimize' => 'Оптимизиране',
	'Vacuum' => 'Консолидиране',
	'Check' => 'Проверка',
	'Repair' => 'Поправка',
	'Truncate' => 'Изрязване',
	'Tables have been truncated.' => 'Таблиците бяха изрязани.',
	'Move to other database' => 'Преместване в друга база данни',
	'Move' => 'Преместване',
	'Tables have been moved.' => 'Таблиците бяха преместени.',
	'Copy' => 'Копиране',
	'Tables have been copied.' => 'Таблиците бяха копирани.',
	
	'Routines' => 'Процедури',
	'Routine has been called, %d row(s) affected.' => array('Беше приложена процедура, %d ред е засегнат.', 'Беше приложена процедура, %d редове са засегнати.'),
	'Call' => 'Прилагане',
	'Parameter name' => 'Име на параметъра',
	'Create procedure' => 'Създаване на процедура',
	'Create function' => 'Създаване на функция',
	'Routine has been dropped.' => 'Процедурата беше премахната.',
	'Routine has been altered.' => 'Процедурата беше променена.',
	'Routine has been created.' => 'Процедурата беше създадена.',
	'Alter function' => 'Промяна на функция',
	'Alter procedure' => 'Промяна на процедура',
	'Return type' => 'Резултат',
	
	'Events' => 'Събития',
	'Event has been dropped.' => 'Събитието беше премахнато.',
	'Event has been altered.' => 'Събитието беше променено.',
	'Event has been created.' => 'Събитието беше създадено.',
	'Alter event' => 'Промяна на събитие',
	'Create event' => 'Създаване на събитие',
	'At given time' => 'В зададено време',
	'Every' => 'Всеки',
	'Schedule' => 'Насрочване',
	'Start' => 'Начало',
	'End' => 'Край',
	'On completion preserve' => 'Запазване след завършване',
	
	'Tables' => 'Таблици',
	'Tables and views' => 'Таблици и изгледи',
	'Table' => 'Таблица',
	'No tables.' => 'Няма таблици.',
	'Alter table' => 'Промяна на таблица',
	'Create table' => 'Създаване на таблица',
	'Table has been dropped.' => 'Таблицата беше премахната.',
	'Tables have been dropped.' => 'Таблиците бяха премахнати.',
	'Tables have been optimized.' => 'Таблиците бяха оптимизирани.',
	'Table has been altered.' => 'Таблицата беше променена.',
	'Table has been created.' => 'Таблицата беше създадена.',
	'Table name' => 'Име на таблица',
	'Show structure' => 'Структура',
	'engine' => 'система',
	'collation' => 'кодировка',
	'Column name' => 'Име на колоната',
	'Type' => 'Вид',
	'Length' => 'Големина',
	'Auto Increment' => 'Автоматично увеличаване',
	'Options' => 'Опции',
	'Comment' => 'Коментар',
	'Default value' => 'Стойност по подразбиране',
	'Default values' => 'Стойности по подразбиране',
	'Drop' => 'Премахване',
	'Are you sure?' => 'Сигурни ли сте?',
	'Size' => 'Големина',
	'Compute' => 'Изчисляване',
	'Move up' => 'Преместване нагоре',
	'Move down' => 'Преместване надолу',
	'Remove' => 'Премахване',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Максималния брой полета е превишен. Моля, увеличете %s.',
	
	'Partition by' => 'Разделяне на',
	'Partitions' => 'Раздели',
	'Partition name' => 'Име на раздела',
	'Values' => 'Стойности',
	
	'View' => 'Изглед',
	'Materialized View' => 'Запаметен изглед',
	'View has been dropped.' => 'Изгледа беше премахнат.',
	'View has been altered.' => 'Изгледа беше променен.',
	'View has been created.' => 'Изгледа беше създаден.',
	'Alter view' => 'Промяна на изглед',
	'Create view' => 'Създаване на изглед',
	'Create materialized view' => 'Създаване на запаметен изглед',
	
	'Indexes' => 'Индекси',
	'Indexes have been altered.' => 'Индексите бяха променени.',
	'Alter indexes' => 'Промяна на индекси',
	'Add next' => 'Добавяне на следващ',
	'Index Type' => 'Вид на индекса',
	'Column (length)' => 'Колона (дължина)',
	
	'Foreign keys' => 'Препратки',
	'Foreign key' => 'Препратка',
	'Foreign key has been dropped.' => 'Препратката беше премахната.',
	'Foreign key has been altered.' => 'Препратката беше променена.',
	'Foreign key has been created.' => 'Препратката беше създадена.',
	'Target table' => 'Таблица приемник',
	'Change' => 'Промяна',
	'Source' => 'Източник',
	'Target' => 'Цел',
	'Add column' => 'Добавяне на колона',
	'Alter' => 'Промяна',
	'Add foreign key' => 'Добавяне на препратка',
	'ON DELETE' => 'При изтриване',
	'ON UPDATE' => 'При промяна',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Колоните източник и цел трябва да са от еднакъв вид, трябва да има индекс на колоните приемник и да има въведени данни.',
	
	'Triggers' => 'Тригери',
	'Add trigger' => 'Добавяне на тригер',
	'Trigger has been dropped.' => 'Тригера беше премахнат.',
	'Trigger has been altered.' => 'Тригера беше променен.',
	'Trigger has been created.' => 'Тригера беше създаден.',
	'Alter trigger' => 'Промяна на тригер',
	'Create trigger' => 'Създаване на тригер',
	'Time' => 'Време',
	'Event' => 'Събитие',
	'Name' => 'Име',
	
	'select' => 'показване',
	'Select' => 'Показване',
	'Select data' => 'Показване на данни',
	'Functions' => 'Функции',
	'Aggregation' => 'Съвкупност',
	'Search' => 'Търсене',
	'anywhere' => 'навсякъде',
	'Search data in tables' => 'Търсене на данни в таблиците',
	'Sort' => 'Сортиране',
	'descending' => 'низходящо',
	'Limit' => 'Редове',
	'Limit rows' => 'Лимит на редовете',
	'Text length' => 'Текст',
	'Action' => 'Действие',
	'Full table scan' => 'Пълно сканиране на таблицата',
	'Unable to select the table' => 'Неуспешно показване на таблицата',
	'No rows.' => 'Няма редове.',
	'%d / ' => '%d / ',
	'%d row(s)' => array('%d ред', '%d реда'),
	'Page' => 'Страница',
	'last' => 'последен',
	'Load more data' => 'Зареждане на повече данни',
	'Loading' => 'Зареждане',
	'whole result' => 'пълен резултат',
	'%d byte(s)' => array('%d байт', '%d байта'),
	
	'Import' => 'Импорт',
	'%d row(s) have been imported.' => array('%d ред беше импортиран.', '%d реда бяха импортирани.'),
	'File must be in UTF-8 encoding.' => 'Файла трябва да е с UTF-8 кодировка.',
	
	// in-place editing in select
	'Modify' => 'Промяна',
	'Ctrl+click on a value to modify it.' => 'Ctrl+щракване в стойността, за да я промените.',
	'Use edit link to modify this value.' => 'Използвайте "редакция" за промяна на данните.',
	
	// %s can contain auto-increment value
	'Item%s has been inserted.' => 'Елементи%s бяха вмъкнати.',
	'Item has been deleted.' => 'Елемента беше изтрит.',
	'Item has been updated.' => 'Елемента беше обновен.',
	'%d item(s) have been affected.' => array('%d елемент беше засегнат.', '%d елемента бяха засегнати.'),
	'New item' => 'Нов елемент',
	'original' => 'оригинал',
	// label for value '' in enum data type
	'empty' => 'празно',
	'edit' => 'редакция',
	'Edit' => 'Редактиране',
	'Insert' => 'Вмъкване',
	'Save' => 'Запис',
	'Saving' => 'Записване',
	'Save and continue edit' => 'Запис и редакция',
	'Save and insert next' => 'Запис и нов',
	'Selected' => 'Избран',
	'Clone' => 'Клониране',
	'Delete' => 'Изтриване',
	'You have no privileges to update this table.' => 'Нямате праве за обновяване на таблицата.',
	
	'E-mail' => 'E-mail',
	'From' => 'От',
	'Subject' => 'Тема',
	'Attachments' => 'Прикачени',
	'Send' => 'Изпращане',
	'%d e-mail(s) have been sent.' => array('%d писмо беше изпратено.', '%d писма бяха изпратени.'),
	
	// data type descriptions
	'Numbers' => 'Числа',
	'Date and time' => 'Дата и час',
	'Strings' => 'Низове',
	'Binary' => 'Двоични',
	'Lists' => 'Списъци',
	'Network' => 'Мрежа',
	'Geometry' => 'Геометрия',
	'Relations' => 'Зависимости',
	
	'Editor' => 'Редактор',
	// date format in Editor: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1-$3-$5',
	// hint for date format - use language equivalents for day, month and year shortcuts
	'[yyyy]-mm-dd' => '[гггг]-мм-дд',
	// hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'ЧЧ:ММ:СС',
	'now' => 'сега',
	'yes' => 'да',
	'no' => 'не',
	
	// general SQLite error in create, drop or rename database
	'File exists.' => 'Файла вече съществува.',
	'Please use one of the extensions %s.' => 'Моля, използвайте някое от разширенията %s.',
	
	// PostgreSQL and MS SQL schema support
	'Alter schema' => 'Промяна на схемата',
	'Create schema' => 'Създаване на схема',
	'Schema has been dropped.' => 'Схемата беше премахната.',
	'Schema has been created.' => 'Схемата беше създадена.',
	'Schema has been altered.' => 'Схемата беше променена.',
	'Schema' => 'Схема',
	'Invalid schema.' => 'Невалидна схема.',
	
	// PostgreSQL sequences support
	'Sequences' => 'Последователности',
	'Create sequence' => 'Създаване на последователност',
	'Sequence has been dropped.' => 'Последователността беше премахната.',
	'Sequence has been created.' => 'Последователността беше създадена.',
	'Sequence has been altered.' => 'Последователността беше променена.',
	'Alter sequence' => 'Промяна на последователност',
	
	// PostgreSQL user types support
	'User types' => 'Видове потребители',
	'Create type' => 'Създаване на вид',
	'Type has been dropped.' => 'Вида беше пермахнат.',
	'Type has been created.' => 'Вида беше създаден.',
	'Alter type' => 'Промяна на вид',
);
