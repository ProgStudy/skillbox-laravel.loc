@csrf
<div class="row">
    <div class="col-6 form-group">
        <label>Название</label>
        <input type="text" name="name" value="{{isset($itemNews) ? $itemNews->name : ''}}" class="form-control">
        <p class="text-danger error-field"></p>
    </div>
    <div class="col-6 form-group">
        <label>Символьный код</label>
        <input type="text" name="slug" value="{{isset($itemNews) ? $itemNews->slug : ''}}" class="form-control">
        <p class="text-danger error-field"></p>
    </div>
</div>
<div class="form-group">
    <label>Краткое содержание</label>
    <textarea name="preview" class="form-control" style="resize:none; height:150px">{{isset($itemNews) ? $itemNews->preview : ''}}</textarea>
    <p class="text-danger error-field"></p>
</div>
<div class="form-group">
    <label>Подробное содержание</label>
    <textarea name="description" class="form-control" style="resize:vertical; height: 250px;"> {{isset($itemNews) ? $itemNews->description : ''}}</textarea>
    <p class="text-danger error-field"></p>
</div>
<div class="btn-group">
    <button type="submit" class="btn btn-primary w-100">Сохранить</button>
    <a href="#" onclick="history.back()" class="btn btn-danger w-100" >Назад</a>
</div>
