<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Edumaster\Shared\Uuid;
use Carbon\Carbon;
use Edumaster\Learning\Worksheet\Domain\ValueObject\QuestionId;
use Edumaster\Learning\Worksheet\Domain\ValueObject\WorksheetId;

class WorksheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $questions = [
            'Laravel' => [
                ['question' => '¿Qué comando se usa para crear un controlador en Laravel?', 'options' => ['php artisan make:controller', 'php artisan new:controller', 'php artisan generate:controller'], 'correct' => 'php artisan make:controller'],
                ['question' => '¿Qué es Eloquent en Laravel?', 'options' => ['ORM', 'Middleware', 'Un comando'], 'correct' => 'ORM'],
                ['question' => '¿Qué archivo define las rutas en Laravel?', 'options' => ['routes/web.php', 'app/Routes.php', 'routes/api.php'], 'correct' => 'routes/web.php'],
                ['question' => '¿Qué método se usa para ejecutar migraciones?', 'options' => ['php artisan migrate', 'php artisan db:migrate', 'php artisan migration:run'], 'correct' => 'php artisan migrate'],
                ['question' => '¿Cómo se recupera el usuario autenticado en Laravel?', 'options' => ['Auth::user()', 'Request::user()', 'User::current()'], 'correct' => 'Auth::user()'],
            ],
            'Vue' => [
                ['question' => '¿Qué directiva se usa para iterar sobre una lista en Vue?', 'options' => ['v-for', 'v-if', 'v-foreach'], 'correct' => 'v-for'],
                ['question' => '¿Qué opción es correcta para declarar un componente en Vue?', 'options' => ['defineComponent', 'createComponent', 'Vue.component'], 'correct' => 'defineComponent'],
                ['question' => '¿Cómo se captura un evento en Vue?', 'options' => ['@click="handler"', 'v-on:click="handler"', 'Ambas'], 'correct' => 'Ambas'],
                ['question' => '¿Cuál es el propósito del `setup` en Vue 3?', 'options' => ['Definir estado reactivo y lógica', 'Configurar rutas', 'Estilizar el componente'], 'correct' => 'Definir estado reactivo y lógica'],
                ['question' => '¿Cómo se define una propiedad en un componente Vue?', 'options' => ['props: ["title"]', 'data() { return { title: "" } }', 'computed: { title() {} }'], 'correct' => 'props: ["title"]'],
            ],
            'Programación' => [
                ['question' => '¿Qué paradigma sigue PHP mayormente?', 'options' => ['POO', 'Funcional', 'Reactivo'], 'correct' => 'POO'],
                ['question' => '¿Qué tipo de lenguaje es JavaScript?', 'options' => ['Interpretado', 'Compilado', 'Intermedio'], 'correct' => 'Interpretado'],
                ['question' => '¿Qué significa SOLID en programación?', 'options' => ['Principios de diseño', 'Librería de JS', 'Un framework'], 'correct' => 'Principios de diseño'],
                ['question' => '¿Cuál es el operador lógico de AND en PHP?', 'options' => ['&&', '||', '!'], 'correct' => '&&'],
                ['question' => '¿Qué tipo de base de datos usa SQL?', 'options' => ['Relacional', 'NoSQL', 'Grafos'], 'correct' => 'Relacional'],
            ]
        ];

        for ($i = 1; $i <= 22; $i++) {
            $worksheetId = (new WorksheetId())->value();
            $teacherId = DB::table('users')->where('email', 'teacher@edumaster.dev')->value('user_id');

            DB::table('worksheets')->insert([
                'worksheet_id' => $worksheetId,
                'teacher_id' => $teacherId,
                'title' => "Worksheet #$i",
                'description' => "Preguntas sobre Laravel, Vue y programación.",
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $topics = array_keys($questions);
            $selectedQuestions = [];
            while (count($selectedQuestions) < 5) {
                $topic = $topics[array_rand($topics)];
                $question = $questions[$topic][array_rand($questions[$topic])];

                if (!in_array($question, $selectedQuestions)) {
                    $selectedQuestions[] = $question;
                }
            }

            foreach ($selectedQuestions as $q) {
                DB::table('worksheet_questions')->insert([
                    'question_id' => (new QuestionId())->value(),
                    'worksheet_id' => $worksheetId,
                    'question' => $q['question'],
                    'words' => json_encode($q['options'], true),
                    'correct_word' => $q['correct'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
