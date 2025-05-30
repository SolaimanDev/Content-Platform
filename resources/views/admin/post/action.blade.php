<div class="btn-group">
    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-primary">
        <i class="fas fa-edit"></i>
    </a>
    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</div>