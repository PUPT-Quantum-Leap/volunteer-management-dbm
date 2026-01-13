@if (count($backups) > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Size</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($backups as $backup)
                    <tr>
                        <td>
                            <i class="fas fa-file-code"></i>
                            {{ $backup['filename'] }}
                        </td>
                        <td>{{ $backup['size'] }}</td>
                        <td>{{ $backup['created_at'] }}</td>
                        <td>
                            <div class="action-links">
                                <button class="action-btn action-btn-view" onclick="downloadBackup('{{ $backup['filename'] }}')" title="Download">
                                    <i class="fas fa-download"></i> Download
                                </button>
                                <button class="action-btn action-btn-delete" onclick="deleteBackup('{{ $backup['filename'] }}')" title="Delete">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div style="text-align: center; padding: 2rem; color: #999;">
        <i class="fas fa-database" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
        <p>No backups found. Create your first backup to protect your data.</p>
    </div>
@endif
