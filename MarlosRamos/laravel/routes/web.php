<?php

// Web Controllers
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\TesteRepresentacionalController;

// Dashboard Controllers
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\AssessmentController;
use App\Http\Controllers\Dashboard\ClassroomController;
use App\Http\Controllers\Dashboard\CommentController;
use App\Http\Controllers\Dashboard\CourseController;
use App\Http\Controllers\Dashboard\MatriculationCourseController;
use App\Http\Controllers\Dashboard\MatriculationTestController;
use App\Http\Controllers\Dashboard\ModuleController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\StudentController;
use App\Http\Controllers\Dashboard\TeacherController;
use App\Http\Controllers\Dashboard\TestController;
use App\Http\Controllers\Eduz\CourseController as EduzCourseController;
// Demais Controllers
use App\Http\Controllers\StripeController;


use Illuminate\Support\Facades\Route;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home.index');
});

Route::controller(TesteRepresentacionalController::class)->group(function () {
    Route::get('/teste-representacional', 'index')->name('teste.representacional.index');
    Route::get('/teste-representacional/{uuid}', 'show')->name('teste.representacional.show');

    Route::post('/teste-representacional', 'store')->name('teste.representacional.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::controller(StripeController::class)->group(function () {
        Route::get('/checkout', 'checkoutForm')->name('checkout.form');
        Route::post('/create-checkout-session', 'createCheckoutSession')->name('checkout.session');
        Route::get('/success', 'success')->name('payment.success');
        Route::get('/cancel', 'cancel')->name('payment.cancel');

        Route::post('/stripe/webhook', 'webhook')->name('stripe.webhook');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/perfil', 'edit')->name('profile.edit');

        Route::patch('/perfil', 'update')->name('profile.update');

        Route::delete('/perfil', 'destroy')->name('profile.destroy');
    });

    Route::prefix('painel-aluno')->middleware(['role:1'])->group(function () {
        Route::controller(StudentController::class)->group(function () {
            Route::get('/', 'dashBoard')->name('student.dashBoard');
            Route::get('/todos-cursos', 'allCourses')->name('student.allCourses');
            Route::get('/meus-cursos', 'myCourses')->name('student.myCourses');
            Route::get('/meus-testes', 'myTests')->name('student.myTests');
            Route::get('/meus-testes/resultado', 'resultTest')->name('student.resultTest');
            Route::get('/meu-curso/{uuid}', 'courseShow')->name('student.courseShow');
            Route::get('/duvidas', 'duvidas')->name('student.duvidas');
            Route::get('/comentarios-respostas', 'comentariosRespostas')->name('student.comentariosRespostas');

            Route::post('/meu-teste/salvar', 'saveTest')->name('student.saveTest');
        });

        Route::controller(AssessmentController::class)->group(function () {
            Route::post('/avaliacoes', 'store')->name('assessment.store');

            Route::delete('/avaliacoes/{id}', 'destroy')->name('assessment.destroy');
        });

        Route::controller(MatriculationCourseController::class)->group(function () {
            Route::post('/matricula-curso/{course_uuid}/{user_uuid}', 'store')->name('matriculation.course.store');

            Route::delete('/matriculas-curso/{id}', 'destroy')->name('matriculation.course.destroy');
        });

        Route::controller(MatriculationTestController::class)->group(function () {
            Route::post('/matricula-teste/{test_uuid}/{user_uuid}', 'store')->name('matriculation.test.store');

            Route::delete('/matriculas-teste/{id}', 'destroy')->name('matriculation.test.destroy');
        });

        Route::controller(ClassroomController::class)->group(function () {
            Route::get('/aula/{uuid_classroom}', 'show')->name('student.classroom.show');

            Route::post('/aula', 'store')->name('classroom.store');
            Route::post('/aula-completa/{uuid_classroom}', 'completeClassroom')->name('classroom.completeClassroom');

            Route::put('/aula/{uuid_classroom}/editar', 'update')->name('classroom.update');

            Route::delete('/aula/{uuid_classroom}', 'destroy')->name('classroom.destroy');
        });

        Route::controller(CommentController::class)->group(function () {
            Route::get('/comentarios', 'index')->name('comment.index');
            Route::get('/comentarios/{uuid_classroom}/{id}', 'show')->name('comment.classroomShow');

            Route::post('/comentarios/{uuid_classroom}', 'store')->name('comment.store');

            Route::delete('/comentarios/{id}', 'destroy')->name('comment.destroy');
        });
    });

    // Rotas da área do professor
    Route::prefix('painel-professor')->middleware(['role:2'])->group(function () {
        Route::controller(TeacherController::class)->group(function () {
            Route::get('/', 'dashBoard')->name('teacher.dashBoard');
            Route::get('/meus-cursos', 'myCourses')->name('teacher.myCourses');
            Route::get('/meus-testes', 'myTests')->name('teacher.myTests');
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

        Route::controller(TestController::class)->group(function () {
            Route::get('/testes', 'index')->name('test.index');
            Route::get('/teste/{uuid}', 'show')->name('test.show');

            Route::post('/testes', 'store')->name('test.store');

            Route::put('/teste/{uuid}', 'update')->name('test.update');

            Route::delete('/teste/{uuid}', 'destroy')->name('test.destroy');
        });

        Route::controller(ClassroomController::class)->group(function () {
            Route::get('/aula/{uuid_classroom}', 'show')->name('tacher.classroom.show');

            Route::post('/aula', 'store')->name('classroom.store');
            Route::post('/aula-completa/{uuid_classroom}', 'completeClassroom')->name('classroom.completeClassroom');

            Route::put('/aula/{uuid_classroom}/editar', 'update')->name('classroom.update');

            Route::delete('/aula/{uuid_classroom}', 'destroy')->name('classroom.destroy');
        });

        Route::controller(EduzCourseController::class)->group(function () {
            Route::get('/eduzz/account', 'account')->name('eduzz.courses.account');            
            Route::get('/eduzz/index', 'index')->name('eduzz.courses.index');
        });
    });

    // Rotas da área do administrador
    Route::prefix('painel-admin')->middleware(['role:3'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/', 'dashBoard')->name('admin.dashBoard');
            Route::get('/comentarios', 'comentarios')->name('admin.comentarios');
            Route::get('/avaliacoes', 'avaliacoes')->name('admin.avaliacoes');

            Route::post('/comentarios/{id}/responder', 'responderComentario')->name('admin.responderComentario');
            Route::post('/avaliacoes/{id}/responder', 'responderAvaliacao')->name('admin.responderAvaliacao');
        });
    });
});

require __DIR__ . '/auth.php';
