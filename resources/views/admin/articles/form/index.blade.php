@csrf
<div class="row">
    <div class="col-6 form-group">
        <label>Название</label>
        <input type="text" name="name" value="{{isset($article) ? $article->name : ''}}" class="form-control">
        <p class="text-danger error-field"></p>
    </div>
    <div class="col-6 form-group">
        <label>Символьный код</label>
        <input type="text" name="slug" value="{{isset($article) ? $article->slug : ''}}" class="form-control">
        <p class="text-danger error-field"></p>
    </div>
</div>
<div class="form-group">
    <label>Краткое содержание</label>
    <textarea name="preview" class="form-control" style="resize:none; height:150px">{{isset($article) ? $article->preview : ''}}</textarea>
    <p class="text-danger error-field"></p>
</div>
<div class="form-group">
    <label>Подробное содержание</label>
    <textarea name="description" class="form-control" style="resize:vertical; height: 250px;"> {{isset($article) ? $article->description : ''}}</textarea>
    <p class="text-danger error-field"></p>
</div>
<div class="form-group">
    <label>Теги</label>
    <input type="text" name="tags" value="{{isset($article) ? $article->tags->pluck('name')->implode(',') : ''}}" class="form-control">
    <p class="text-danger error-field"></p>
</div>
<div class="form-group form-check">
    <input type="checkbox" {{isset($article) && $article->has_public ? 'checked=""' : ''}} class="form-check-input" id="checkoxHasPublic" value="1" name="has_public">
    <label class="form-check-label" for="checkoxHasPublic">Сделать публичной</label>
    <p class="text-danger error-field" style="position: relative; right: 20px;"></p>
</div>
<div class="btn-group">
    <button type="submit" class="btn btn-primary w-100">Сохранить</button>
    <a href="/admin/articles/" class="btn btn-danger w-100" >Назад</a>
</div>