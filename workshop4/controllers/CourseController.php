<?php

require_once BASE_PATH . '/models/Course.php';
require_once BASE_PATH . '/models/Career.php';

class CourseController extends Controller
{
    private Course $courses;
    private Career $careers;

    public function __construct()
    {
        // Todo el módulo de cursos requiere una sesión válida y activa
        Auth::requireLogin();

        $this->courses = new Course();
        $this->careers = new Career();
    }

    // GET courses: lista de cursos
    public function index(): void
    {
        $this->render('courses/index', [
            'title' => 'Cursos',
            'courses' => $this->courses->all(),
        ]);
    }

    // GET courses/create: formulario vacío
    public function create(): void
    {
        $this->renderForm([
            'id' => null,
            'name' => '',
            'course_code' => '',
            'career_id' => '',
            'credits' => '',
            'description' => '',
        ]);
    }

    // POST courses/store
    public function store(): void
    {
        $data = Course::sanitize($_POST);

        if ($data === null) {
            redirect('courses/create', ['error' => 'invalid_course_input']);
        }

        try {
            if ($this->careers->find($data['career_id']) === false) {
                redirect('courses/create', ['error' => 'invalid_career']);
            }

            $this->courses->create($data);
        } catch (PDOException $exception) {
            // 23000 = violación de integridad (llave única del código de curso)
            if ($exception->getCode() === '23000') {
                redirect('courses/create', ['error' => 'course_code_taken']);
            }

            error_log('Course creation database error: ' . $exception->getMessage());
            redirect('courses/create', ['error' => 'server_error']);
        }

        redirect('courses', ['success' => 'course_created']);
    }

    // GET courses/edit&id=N: formulario con los datos del curso
    public function edit(): void
    {
        $id = $_GET['id'] ?? null;
        $course = ctype_digit((string) $id) ? $this->courses->find((int) $id) : false;

        if ($course === false) {
            redirect('courses', ['error' => 'course_not_found']);
        }

        $this->renderForm($course);
    }

    // POST courses/update
    public function update(): void
    {
        $id = $this->input('id');

        if (!ctype_digit((string) $id)) {
            redirect('courses', ['error' => 'course_not_found']);
        }

        $id = (int) $id;
        $data = Course::sanitize($_POST);

        if ($data === null) {
            redirect('courses/edit', ['id' => $id, 'error' => 'invalid_course_input']);
        }

        try {
            if ($this->courses->find($id) === false) {
                redirect('courses', ['error' => 'course_not_found']);
            }

            if ($this->careers->find($data['career_id']) === false) {
                redirect('courses/edit', ['id' => $id, 'error' => 'invalid_career']);
            }

            $this->courses->update($id, $data);
        } catch (PDOException $exception) {
            // 23000 = violación de integridad (llave única del código de curso)
            if ($exception->getCode() === '23000') {
                redirect('courses/edit', ['id' => $id, 'error' => 'course_code_taken']);
            }

            error_log('Course update database error: ' . $exception->getMessage());
            redirect('courses/edit', ['id' => $id, 'error' => 'server_error']);
        }

        redirect('courses', ['success' => 'course_updated']);
    }

    // POST courses/delete
    public function delete(): void
    {
        $id = $this->input('id');

        if (!ctype_digit((string) $id)) {
            redirect('courses', ['error' => 'invalid_course_input']);
        }

        try {
            $this->courses->delete((int) $id);
        } catch (PDOException $exception) {
            error_log('Course deletion database error: ' . $exception->getMessage());
            redirect('courses', ['error' => 'server_error']);
        }

        redirect('courses', ['success' => 'course_deleted']);
    }

    // El mismo formulario sirve para crear y para editar
    private function renderForm(array $course): void
    {
        $editing = $course['id'] !== null;

        $this->render('courses/form', [
            'title' => $editing ? 'Editar Curso' : 'Crear Curso',
            'course' => $course,
            'careers' => $this->careers->all(),
            'editing' => $editing,
            'formAction' => url($editing ? 'courses/update' : 'courses/store'),
        ]);
    }
}
