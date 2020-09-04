<form class="needs-validation formPrevent" method="post"
      action="{{route('material.update',$material->slug)}}" enctype="multipart/form-data">
    @method('PATCH')
    @csrf

    <div class="form-group mb-3">
        <label for="titleMaterial">Τίτλος <span class="text-danger"> *</span></label>
        <input name="title" type="text" class="form-control" id="titleMaterial"
               value="{{old('material', $material->title)}}" placeholder="Εισάγετε τίτλο...">
        @error("title")
        <div class="invalid-feedback d-block">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="subtitleMaterial">Υποτίτλο<span class="text-danger"> *</span></label>
        <input name="subtitle" type="text" class="form-control" id="subtitleMaterial"
               value="{{old('material', $material->subtitle)}}"
               placeholder="Εισάγετε υποτίτλο...">
        @error("subtitle")
        <div class="invalid-feedback d-block">{{$message}}</div>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="summaryMaterial">Περίληψη</label>
        <textarea name="summary" class="form-control" placeholder="Εισάγετε περίληψη..."
                  id="summaryMaterial" rows="5">{{$material->summary}}</textarea>
    </div>

    <div class="form-group mb-3">
        <label for="descriptionMaterial">Περιγραφή<span class="text-danger"> *</span></label>
        <textarea name="description" class="form-control" placeholder="Εισάγετε περιγραφή..."
                  id="descriptionMaterial" rows="5">{{$material->description}}</textarea>
    </div>

    <div class="form-group mb-3">
        <label for="contentMaterial">Περιεχόμενο μαθήματος <span class="text-danger">
                                    *</span></label>
        <textarea name="content" class="form-control"
                  value="{{old('material', $material->content)}}" id="contentMaterial"
                  rows="5">{{$material->content}}</textarea>
    </div>

    <input type="hidden" class="form-control" id="topicMaterialHidden">
    <input name="type" type="hidden" class="form-control" id="typeMaterialHidden">
    <input name="status" value="{{$material->status == "0" ? "" : 1}}" type="hidden"
           class="form-control" id="activeMaterialHidden">
    <input name="video_link" type="hidden" class="form-control" id="urlMaterialHiden">
    <input name="cover" hidden type="file" class="form-control" id="coverMaterialHidden">
    <input name="instructor" type="hidden" class="form-control" id="instructorMaterialHidden">

</form>
