<?php $__env->startSection('title', 'Rooms'); ?>

<?php
    $stockPhotos = [
        'https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1566665797739-1674de7a421a?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1590490360182-c33d57733427?q=80&w=500&auto=format&fit=crop',
        'https://images.unsplash.com/photo-1560185893-a55cbc8c57e8?q=80&w=500&auto=format&fit=crop',
    ];
?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">Available Rooms</h1>
            <p class="text-muted mb-0"><?php echo e($rooms->count()); ?> <?php echo e(Str::plural('room', $rooms->count())); ?> found</p>
        </div>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('rooms.create')); ?>" class="btn btn-outline-navy btn-sm"><i class="bi bi-plus-lg me-1"></i>Add Room</a>
        <?php endif; ?>
    </div>

    <div class="row g-4">
        <div class="col-lg-3">
            <form method="GET" action="<?php echo e(route('rooms.index')); ?>">
                <div class="filter-block panel shadow-card">
                    <h6>Price Range (per night)</h6>
                    <div class="d-flex gap-2">
                        <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" class="form-control form-control-sm" placeholder="Min">
                        <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" class="form-control form-control-sm" placeholder="Max">
                    </div>
                </div>

                <div class="filter-block panel shadow-card">
                    <h6>Room Type</h6>
                    <?php $__currentLoopData = $roomTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="types[]" value="<?php echo e($type); ?>" id="type-<?php echo e($loop->index); ?>"
                                <?php echo e(in_array($type, (array) request('types', [])) ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="type-<?php echo e($loop->index); ?>"><?php echo e($type); ?></label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="filter-block panel shadow-card">
                    <h6>Minimum Guests</h6>
                    <select name="capacity" class="form-select form-select-sm">
                        <option value="">Any</option>
                        <option value="1" <?php echo e(request('capacity') == 1 ? 'selected' : ''); ?>>1+</option>
                        <option value="2" <?php echo e(request('capacity') == 2 ? 'selected' : ''); ?>>2+</option>
                        <option value="3" <?php echo e(request('capacity') == 3 ? 'selected' : ''); ?>>3+</option>
                        <option value="4" <?php echo e(request('capacity') == 4 ? 'selected' : ''); ?>>4+</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-orange w-100 btn-sm">Apply Filters</button>
                <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-outline-navy w-100 btn-sm mt-2">Clear</a>
            </form>
        </div>

        <div class="col-lg-9">
            <div class="d-flex flex-column gap-3">
                <?php $__empty_1 = true; $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $img = $room->image ? Storage::url($room->image) : $stockPhotos[$i % count($stockPhotos)]; ?>
                    <div class="panel shadow-card p-3">
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <img src="<?php echo e($img); ?>" class="w-100 rounded-3" style="height: 120px; object-fit: cover;" alt="<?php echo e($room->room_type); ?>">
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-1"><?php echo e($room->room_type); ?></h5>
                                <div class="text-muted small mb-2"><i class="bi bi-geo-alt"></i> StayPinas &middot; Room <?php echo e($room->room_number); ?></div>
                                <div class="room-card__facts mb-2">
                                    <span><i class="bi bi-people"></i> <?php echo e($room->capacity); ?> Guests</span>
                                    <span><i class="bi bi-wifi"></i> Free Wi-Fi</span>
                                    <span><i class="bi bi-cup-hot"></i> Breakfast</span>
                                </div>
                                <span class="badge <?php echo e($room->status === 'available' ? 'badge-completed' : 'badge-cancelled'); ?>">
                                    <?php echo e(ucfirst($room->status)); ?>

                                </span>
                            </div>
                            <div class="col-md-3 text-md-end">
                                <div class="room-card__price mb-2">&#8369;<?php echo e(number_format($room->price_per_night, 0)); ?><small> / night</small></div>
                                <a href="<?php echo e(route('bookings.create', ['room_id' => $room->id])); ?>" class="btn btn-orange btn-sm w-100 mb-2">Book Now</a>
                                <?php if(auth()->guard()->check()): ?>
                                    <div class="d-flex justify-content-md-end gap-2">
                                        <a href="<?php echo e(route('rooms.edit', $room)); ?>" class="btn btn-outline-navy btn-sm"><i class="bi bi-pencil"></i></a>
                                        <form action="<?php echo e(route('rooms.destroy', $room)); ?>" method="POST" onsubmit="return confirm('Delete this room?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-navy btn-sm"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="panel shadow-card text-center py-5 text-muted">
                        <i class="bi bi-door-open" style="font-size: 2rem;"></i>
                        <h5 class="mt-3 mb-2">No rooms match your filters</h5>
                        <p class="mb-3">Try adjusting your filters or clearing them.</p>
                        <a href="<?php echo e(route('rooms.index')); ?>" class="btn btn-orange btn-sm">Clear Filters</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.booking', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\alvinjay\resources\views/rooms/index.blade.php ENDPATH**/ ?>