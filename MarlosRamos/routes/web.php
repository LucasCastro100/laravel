<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AssessmentController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\CommentController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\MatriculationController;
use App\Http\Controllers\Dashboard\ModuleController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/perfil', 'edit')->name('profile.edit');

        Route::patch('/perfil', 'update')->name('profile.update');

        Route::delete('/perfil', 'destroy')->name('profile.destroy');
    });

    Route::controller(CommentController::class)->group(function () {
        Route::post('/comentarios/{uuid_classroom}', 'store')->name('comment.store');

        Route::delete('/comentarios/{id}', 'destroy')->name('comment.destroy');
    });

    Route::controller(AssessmentController::class)->group(function () {
        Route::post('/avaliacoes', 'store')->name('assessment.store');

        Route::delete('/avaliacoes/{id}', 'destroy')->name('assessment.destroy');
    });

    
  
    Route::middleware(['role:0'])->group(function () {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/todos-cursos', 'allCourses')->name('student.allCourses');
            Route::get('/meus-cursos', 'myCourses')->name('student.myCourses');
            Route::get('/duvidas', 'duvidas')->name('student.duvidas');
            Route::get('/comentarios-respostas', 'comentariosRespostas')->name('student.comentariosRespostas');
        });

        Route::controller(MatriculationController::class)->group(function () {
            Route::post('/matricula/{course_uuid}/{user_uuid}', 'store')->name('matriculation.store');
    
            Route::delete('/matriculas/{id}', 'destroy')->name('matriculation.destroy');
        });
    });

    // Rotas da área do administrador
    Route::middleware(['role:1'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/admin', 'index')->name('admin.index');
            Route::get('/admin/usuarios', 'allUsers')->name('admin.allUsers');
            Route::get('/admin/comentarios', 'comentarios')->name('admin.comentarios');


            Route::post('/admin/comentarios/{id}/responder', 'responderComentario')->name('admin.responderComentario');

            Route::get('/admin/avaliacoes', 'avaliacoes')->name('admin.avaliacoes');
        });

        Route::controller(CourseController::class)->group(function () {
            Route::get('/cursos', 'index')->name('course.index');
            Route::get('/curso/{uuid}', 'show')->name('course.show');
    
            Route::post('/curso', 'store')->name('course.store');
    
            Route::put('/curso/{uuid}', 'update')->name('course.update');
    
            Route::delete('/curso/{uuid}', 'destroy')->name('course.destroy');
        });

        Route::controller(ModuleController::class)->group(function () {            
            Route::get('/modulo/{uuid_module}', 'index')->name('module.show');

            Route::post('/modulo/{uuid_course}', 'store')->name('module.store');

            Route::put('/modulo/{uuid_module}', 'update')->name('module.update');

            Route::delete('/modulo/{uuid_module}', 'destroy')->name('module.destroy');
        });

        Route::controller(ClassroomController::class)->group(function () {            
            Route::get('/aula/{uuid_classroom}', 'show')->name('classroom.show');

            Route::post('/aula', 'store')->name('classroom.store');

            Route::put('/aula/{uuid_classroom}/editar', 'update')->name('classroom.update');

            Route::delete('/aula/{uuid_classroom}', 'destroy')->name('classroom.destroy');
        });

        Route::controller(TestController::class)->group(function () {
            Route::get('/testes', 'index')->name('test.index');
            Route::get('/teste/{uuid}', 'show')->name('test.show');

            Route::post('/testes', 'store')->name('test.store');

            Route::put('/teste/{uuid}', 'update')->name('test.update');

            Route::delete('/teste/{uuid}', 'destroy')->name('test.destroy');
        });
    });
});

require __DIR__ . '/auth.php';
