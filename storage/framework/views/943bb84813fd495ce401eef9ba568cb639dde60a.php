<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Liste des évenements')); ?>

        </h2>
        <?php if(session('successMsg')): ?>
            <p class="text-center"><?php echo e(session('successMsg')); ?></p>
        <?php elseif(session('errorMsg') || !empty($errorMsg)): ?>
            <p class="text-center"><?php echo e(session('errorMsg')); ?></p>
        <?php endif; ?>
     <?php $__env->endSlot(); ?>
    
    
    <?php if(count($events) > 0): ?>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a href="<?php echo e(route('event.create')); ?>" class="flex justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Créer un évènement</a>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nom
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Place
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>         
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        <?php echo e($event->title); ?>

                                    </th>
                                    <td class="px-6 py-4">
                                        <?php echo e($event->description); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo e(date('d/m/Y', strtotime($event->date))); ?>

                                    </td>
                                    <td class="px-6 py-4">
                                        <?php echo e($event->subcriptions()->count()); ?> / <?php echo e($event->slots); ?>

                                    </td>
                                    <?php if(Auth::user()->id == $event->author_id): ?>
                                        <td class="px-6 py-4 text-right">
                                            <?php if(!Auth::user()->is_registered($event->id, Auth::user()->id)): ?>
                                                <?php if($event->subcriptions()->count() < $event->slots): ?>
                                                    <a href="<?php echo e(url('event/'.$event->id.'/subscribe')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">S'inscrire</a>
                                                <?php else: ?>
                                                    <a href="#" class="bg-gray-700 text-gray font-bold py-2 px-4 rounded">S'inscrire</a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <a href="<?php echo e(url('event/'.$event->id.'/unsubscribe')); ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Se désinscrire</a>
                                            <?php endif; ?>
                                            <a href="<?php echo e(url('event/'.$event->id.'/edit')); ?>" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
                                            <a href="<?php echo e(url('event/'.$event->id.'/delete')); ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</a>
                                        </td>
                                    <?php else: ?>
                                        <?php if(!Auth::user()->is_registered($event->id, Auth::user()->id)): ?>
                                            <td class="px-6 py-4 text-right">
                                                <?php if($event->subcriptions()->count() < $event->slots): ?>
                                                    <a href="<?php echo e(url('event/'.$event->id.'/subscribe')); ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">S'inscrire</a>
                                                <?php else: ?>
                                                    <a href="#" class="bg-gray-700 text-gray font-bold py-2 px-4 rounded">S'inscrire</a>
                                                <?php endif; ?>
                                            </td>
                                        <?php else: ?>
                                            <td class="px-6 py-4 text-right">
                                                <a href="<?php echo e(url('event/'.$event->id.'/unsubscribe')); ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Se désinscrire</a>
                                            </td>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg p-6">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-600">
                                <?php echo e(__('Aucun évenement')); ?>

                            </h3>
                            <p class="mt-3 text-gray-600 dark:text-gray-400">
                                <?php echo e(__('Aucun évenement n\'a été créé pour le moment.')); ?>

                            </p>
                        </div>
                        <a href="<?php echo e(route('event.create')); ?>" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Créer un évènement</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH D:\laragon\www\webevent\resources\views/pages/event/show.blade.php ENDPATH**/ ?>