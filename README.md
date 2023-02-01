--------------------BaseController
1. Дописываем в behavours className
2. Удаляем actionDelete
3. Удаляем findModel
4. Убрать редирект на view после сохранения

--------------------Model
1. Добавить static метод modelName
2. В классе Product поменять beforeSave ???
3. добавить static метод typeId - это для сохранения сущности картинок
4. в класс Gallery добавить типы изображений для п. 3


--------------------SearchModel
1. В методе search вместо find() прописать findModels()
2. Добавить is_active


--------------------View index
1. Удалить $this->title
2. SortableGridView вместо GridView
3. 1-й столбец всегда изображение
4. переделать грид колонки mainImageHtml, is_active
5. is_active - добавить dropdown фильтр



--------------------View view
1. Последние 4 позиции - image_fields, is_active, created_at, updated_at + переделать их на методы




--------------------
