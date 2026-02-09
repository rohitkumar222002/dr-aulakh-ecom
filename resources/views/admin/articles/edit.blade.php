@extends('admin.layouts.app')

@section('content')
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header card-header-bordered justify-content-between">
                    <h3 class="card-title">Edit Article</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.articles.update', $article->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <!-- TITLE -->
                            <div class="col-md-12">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                       value="{{ old('title', $article->title) }}"
                                       class="form-control">
                                @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- THUMBNAIL -->
                            <div class="col-md-6">
                                <label class="form-label">Thumbnail Image</label>
                                <div class="input-group" data-toggle="aizuploader" data-type="image">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Browse
                                        </div>
                                    </div>
                                    <div class="form-control file-amount">Choose File</div>
                                    <input type="hidden" name="thumbnail"
                                           value="{{ old('thumbnail', $article->thumbnail) }}"
                                           class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                @error('thumbnail') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- MULTIPLE IMAGES -->
                            <div class="col-md-6">
                                <label class="form-label">Gallery Images</label>
                                <div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text bg-soft-secondary font-weight-medium">
                                            Browse
                                        </div>
                                    </div>
                                    <div class="form-control file-amount">Choose Files</div>
                                    <input type="hidden" name="images"
                                           value="{{ old('images', $article->images) }}"
                                           class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                                @error('images') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- EXCERPT -->
                            <div class="col-md-12">
                                <label class="form-label">Excerpt</label>
                                <textarea name="excerpt" class="form-control" rows="3">
                                    {{ old('excerpt', $article->excerpt) }}
                                </textarea>
                                @error('excerpt') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- CONTENT -->
                            <div class="col-md-12">
                                <label class="form-label">Content</label>
                                <textarea id="basic-example" name="content" class="form-control">
                                    {{ old('content', $article->content) }}
                                </textarea>
                                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- STATUS -->
                            <div class="col-md-4">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $article->is_active == 1 ? 'selected' : '' }}>Publish</option>
                                    <option value="0" {{ $article->is_active == 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                                @error('is_active') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- SUBMIT -->
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary text-white">Update</button>
                            </div>

                        </div><!-- row end -->

                    </form>
                </div><!-- card-body -->
            </div><!-- card -->

        </div>
    </div>
</div>
@endsection
