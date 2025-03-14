@extends('layout.master-new')
@section('title', __('menu.menu_management'))

@section('css')
    <style>
        .menu-container {
            cursor: move;
            margin-bottom: 15px;
        }

        .menu-wrapper {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            transition: all 0.3s ease;
        }

        .menu-wrapper:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .menu-header {
            padding: 15px;
            background: #f8fafc;
            border-radius: 8px 8px 0 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .menu-body {
            padding: 15px;
        }

        .submenu-container {
            min-height: 50px;
            padding: 10px;
            margin-top: 10px;
            background: #f8fafc;
            border-radius: 6px;
            border: 1px dashed #cbd5e1;
        }

        .submenu-item {
            background: white;
            padding: 10px;
            margin: 5px 0;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .submenu-item:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .drag-handle {
            color: #94a3b8;
            cursor: move;
            padding: 5px;
        }

        .language-toggle {
            display: inline-flex;
            padding: 4px;
            background: #f1f5f9;
            border-radius: 6px;
            margin-left: 15px;
        }

        .language-toggle button {
            padding: 4px 12px;
            border: none;
            background: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .language-toggle button.active {
            background: #fff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .empty-submenu {
            text-align: center;
            padding: 15px;
            color: #64748b;
            font-style: italic;
        }

        .menu-actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            padding: 6px;
            border-radius: 6px;
            line-height: 1;
        }

        .submenu-container {
            transition: all 0.3s ease;
        }

        .submenu-container.collapsed {
            display: none;
        }

        .menu-header .toggle-submenu {
            background: none;
            border: none;
            color: #64748b;
            padding: 5px;
            margin-right: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .menu-header .toggle-submenu.collapsed {
            transform: rotate(-90deg);
        }

        /* Inactive menu styles */
        .menu-inactive {
            opacity: 0.8;
            border-left: 3px solid #dc3545;
        }

        .submenu-inactive {
            opacity: 0.8;
            border-left: 3px solid #dc3545;
        }

        .status-badge {
            margin-left: 8px;
            font-size: 0.75rem;
            padding: 2px 6px;
        }
    </style>
@endsection

@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <h5 class="mb-0">@lang('menu.menu_structure')</h5>
                        </div>
                        <div>
                            <form action="{{ route('admin.menus.sync-departments') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-info btn-sm me-2">
                                    <i class="ti ti-refresh"></i> @lang('menu.sync_departments')
                                </button>
                            </form>
                            <a href="{{ route('menus.create') }}" class="btn btn-primary btn-sm">
                                <i class="ti ti-plus"></i> @lang('menu.add_menu')
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="mainMenuContainer">
                            @foreach ($menu1 as $menu)
                                <div class="menu-container" data-id="{{ $menu->id }}">
                                    <div class="menu-wrapper {{ !$menu->is_active ? 'menu-inactive' : '' }}">
                                        <div class="menu-header">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex align-items-center">
                                                    <i class="ti ti-grip-vertical drag-handle"></i>
                                                    <button type="button" class="toggle-submenu" title="@lang('menu.toggle_submenu')">
                                                        <i class="ti ti-chevron-down"></i>
                                                    </button>
                                                    <div class="ms-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="menu-title" lang="th">
                                                                {{ $menu->translations->where('language_code', 'th')->first()->name ?? '' }}
                                                            </div>
                                                            @if (!$menu->is_active)
                                                                <span
                                                                    class="badge bg-danger status-badge">@lang('menu.inactive')</span>
                                                            @endif
                                                        </div>
                                                        <div class="menu-title d-none" lang="en">
                                                            {{ $menu->translations->where('language_code', 'en')->first()->name ?? '' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="menu-actions">
                                                    <a href="{{ route('menus.edit', $menu->id) }}"
                                                        class="btn btn-primary btn-icon" title="@lang('menu.edit_tooltip')">
                                                        <i class="ti ti-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-icon delete-menu"
                                                        data-id="{{ $menu->id }}" title="@lang('menu.delete_tooltip')">
                                                        <i class="ti ti-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="menu-body">
                                            <div class="submenu-container" data-parent="{{ $menu->id }}">
                                                @if ($menu->children->count() > 0)
                                                    @foreach ($menu->children as $child)
                                                        <div class="submenu-item {{ !$child->is_active ? 'submenu-inactive' : '' }}"
                                                            data-id="{{ $child->id }}">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ti ti-grip-vertical drag-handle"></i>
                                                                    <div class="ms-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="submenu-title" lang="th">
                                                                                {{ $child->translations->where('language_code', 'th')->first()->name ?? '' }}
                                                                            </div>
                                                                            @if (!$child->is_active)
                                                                                <span
                                                                                    class="badge bg-danger status-badge">@lang('menu.inactive')</span>
                                                                            @endif
                                                                        </div>
                                                                        <div class="submenu-title d-none" lang="en">
                                                                            {{ $child->translations->where('language_code', 'en')->first()->name ?? '' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="menu-actions">
                                                                    <a href="{{ route('menus.edit', $child->id) }}"
                                                                        class="btn btn-primary btn-icon"
                                                                        title="@lang('menu.edit_tooltip')">
                                                                        <i class="ti ti-edit"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-icon delete-menu"
                                                                        data-id="{{ $child->id }}"
                                                                        title="@lang('menu.delete_tooltip')">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="empty-submenu">@lang('menu.no_submenu')</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('assets/vendor/sortable/Sortable.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Initialize Sortable
            new Sortable(mainMenuContainer, {
                animation: 150,
                handle: '.menu-wrapper',
                draggable: '.menu-container',
                ghostClass: 'menu-ghost',
                onEnd: function(evt) {
                    updateOrder(evt.to.children, null, true);
                }
            });

            var lang = {
                'confirm': '@lang('menu.confirm_delete')'
            }

            // Submenu toggle handlers
            document.querySelectorAll('.toggle-submenu').forEach(btn => {
                btn.addEventListener('click', function() {
                    const menuWrapper = this.closest('.menu-wrapper');
                    const submenuContainer = menuWrapper.querySelector('.submenu-container');
                    const icon = this.querySelector('i');

                    // Toggle submenu visibility
                    submenuContainer.classList.toggle('collapsed');

                    // Toggle button state
                    this.classList.toggle('collapsed');

                    // Toggle icon
                    if (submenuContainer.classList.contains('collapsed')) {
                        icon.classList.remove('ti-chevron-down');
                        icon.classList.add('ti-chevron-right');
                    } else {
                        icon.classList.remove('ti-chevron-right');
                        icon.classList.add('ti-chevron-down');
                    }
                });
            });

            // Initialize Sortable for submenus
            document.querySelectorAll('.submenu-container').forEach(container => {
                new Sortable(container, {
                    group: 'shared',
                    animation: 150,
                    handle: '.drag-handle',
                    draggable: '.submenu-item',
                    ghostClass: 'submenu-ghost',
                    onAdd: function(evt) {
                        const parentId = evt.to.dataset.parent;
                        updateOrder([...evt.to.children], parentId);
                    },
                    onUpdate: function(evt) {
                        const parentId = evt.to.dataset.parent;
                        updateOrder([...evt.to.children], parentId);
                    }
                });
            });

            // Delete menu handler
            document.querySelectorAll('.delete-menu').forEach(btn => {
                btn.addEventListener('click', function() {
                    Swal.fire({
                        title: '@lang('symbol.confirm_delete')',
                        text: lang.confirm,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '@lang('translation.confirm')',
                        cancelButtonText: '@lang('translation.cancel')'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const menuId = this.dataset.id;
                            fetch(`/admin/menus/${menuId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector(
                                            'meta[name="csrf-token"]').content,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            '@lang('menu.deleted')',
                                            '@lang('menu.menu_deleted_success')',
                                            'success'
                                        ).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire(
                                            '@lang('menu.error')',
                                            '@lang('menu.delete_failed')',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    Swal.fire(
                                        '@lang('menu.error')',
                                        '@lang('menu.delete_failed')',
                                        'error'
                                    );
                                });
                        }
                    });
                });
            });

            function updateOrder(items, parentId, isMainMenu = false) {
                const itemIds = Array.from(items)
                    .filter(el => el.dataset.id)
                    .map(el => el.dataset.id);

                fetch('/admin/menus/update-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        items: itemIds,
                        parent_id: parentId,
                        is_main_menu: isMainMenu
                    })
                });
            }
        });
    </script>
@endsection
