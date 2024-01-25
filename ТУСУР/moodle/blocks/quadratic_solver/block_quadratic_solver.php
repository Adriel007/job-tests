<?php

class block_quadratic_solver extends block_base
{
    public function init()
    {
        $this->title = get_string('pluginname', 'block_quadratic_solver');
    }

    public function get_content()
    {
        global $OUTPUT, $DB;

        $this->content = new stdClass();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $a = optional_param('a', 0, PARAM_INT);
            $b = optional_param('b', 0, PARAM_INT);
            $c = optional_param('c', 0, PARAM_INT);

            $delta = $b * $b - 4 * $a * $c;

            if ($delta >= 0) {
                $x1 = (-$b + sqrt($delta)) / (2 * $a);
                $x2 = (-$b - sqrt($delta)) / (2 * $a);
            } else {
                $x1 = $x2 = 'Комплексные корни';
            }

            $record = new stdClass();
            $record->a = $a;
            $record->b = $b;
            $record->c = $c;
            $record->x1 = $x1;
            $record->x2 = $x2;
            $record->timecreated = time();

            $DB->insert_record('quadratic_solver_results', $record);

            $this->content->text = "Результаты: x1 = $x1, x2 = $x2";
        } else {
            $form = $this->output->heading('Решение квадратного уравнения', 3);
            $form .= '<form method="post" action="">';
            $form .= '<label for="a">Значение a:</label>';
            $form .= '<input type="text" name="a" id="a" required><br>';
            $form .= '<label for="b">Значение b:</label>';
            $form .= '<input type="text" name="b" id="b" required><br>';
            $form .= '<label for="c">Значение c:</label>';
            $form .= '<input type="text" name="c" id="c" required><br>';
            $form .= '<input type="submit" value="Вычислить">';
            $form .= '</form>';

            $this->content->text = $this->output->box($form, 'generalbox');
        }

        return $this->content;
    }
}
