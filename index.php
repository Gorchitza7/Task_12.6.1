<?php

$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];

// создаем массив со значением  fullname из массива $example_persons_array
$fullNameString = [];
foreach ($example_persons_array as $fullname) {
    $fullNameString[] = $fullname['fullname'];
}

function arrCount($arr)
{
    $arrCount = count($arr);
    return $arrCount;
}

// -------------------------------------------------------
$surnameNamePatronomyc = explode(" ", $fullNameString[3]); 
// разбиваем строку Ф.И.О на числовой массив

// -------------------------------------------------------
// массив из трех элементов Фамилия, Имя, Отчество 
function getPartsFromFullname($nameString)
{ // Создаем массив для создание ключей surname name patronomyc
    $initials = ['surname', 'name', 'patronomyc',];
    $surnameNamePatronomyc = explode(" ", $nameString); 
    $arrFulnameAssociative = array_combine($initials, $surnameNamePatronomyc);
    return $arrFulnameAssociative;
}

// Передаем строку с Ф.И.О из массива $fullNameString в функцию getPartsFromFullname
$associativArrFullname = getPartsFromFullname($fullNameString[1]);
// выводим ассоциативный массив из функции getPartsFromFullname

// ------------------------------------------------------------------------
print_r("\n\n Вывод функции getPartsFromFullname \n");
print_r($associativArrFullname);
// ------------------------------------------------------------------------

// ---- принимает три строки "Ф" "И" "О" и склеивает в одну ----
function getFullnameFromParts($surname, $name, $patronomyc)
{
    $stringFullname = $surname . " " . $name . " " . $patronomyc;
    return $stringFullname;
}
//--------------------------------------------------------------
echo "\n\n Вывод функции getFullnameFromParts:\n";
echo getFullnameFromParts($surnameNamePatronomyc[0], $surnameNamePatronomyc[1], $surnameNamePatronomyc[2]);
//--------------------------------------------------------------


// --- Функция возвращающая Имя и первую букву фамилии ----
function getShortName($nameString)
{
    // Получаем массив сформированный функцией getPartsFromFullname
    $arrNameString = getPartsFromFullname($nameString);
    // Имя в отдельную переменную
    $name = $arrNameString['name'];
    // Получаем первую букву фамилии
    $surname = mb_substr($arrNameString['surname'], 0, 1);
    $shortName =  $name . " " . $surname . ".";
    return $shortName;
}

// ------------------------------------------------------------------------
echo "\n\n Вывод функции getShortName:\n";
echo getShortName($fullNameString[4]);
// ------------------------------------------------------------------------

// --- Функция определения пола по Ф.И.О ---
function getGenderFromName($nameString)
{
    // Получаем массив сформированный функцией getPartsFromFullname
    $arrNameString = getPartsFromFullname($nameString);
    // Начальное значение признака пола
    $gender = 0;

    // Проверка окончаний:
    if (mb_substr($arrNameString['patronomyc'], -2) == 'ич') {
        ++$gender;
    }
    if (mb_substr($arrNameString['name'], -1) == 'й' || mb_substr($arrNameString['name'], -1) == 'н') {
        ++$gender;
    }
    if (mb_substr($arrNameString['surname'], -1) == 'в') {
        ++$gender;
    }
    // Проверка на женские признаки
    if (mb_substr($arrNameString['patronomyc'], -3) == 'вна') {
        --$gender;
    }
    if (mb_substr($arrNameString['name'], -1) == 'а') {
        --$gender;
    }
    if (mb_substr($arrNameString['surname'], -1) == 'ва') {
        --$gender;
    }
    // Выводим значение пола для проверки
    switch ($gender <=> 0) {
        case 1:
            // echo 'Мужчина';
            return 1;
            break;
        case -1:
            // echo 'Женщина';
            return -1;
            break;
        default:
            // echo 'Пол не определён';
            return 0;
    }
}

// ------------------------------------------------------------------------
echo "\n\n Вывод функции getGenderFromName:\n";
echo getGenderFromName($fullNameString[9]);
// ------------------------------------------------------------------------

// --- Функция определения полового признака - getGenderDescription ---
function getGenderDescription($arr)
{
    $male = 0;
    $female = 0;
    $nogender = 0;

    // Считаем количесвто мужчин, женщин и неопределенных полов
    for ($i = 0; $i < count($arr); $i++) {
        if (getGenderFromName($arr[$i]) == 1) {
            ++$male;
        }
        if (getGenderFromName($arr[$i]) == -1) {
            ++$female;
        }
        if (getGenderFromName($arr[$i]) == 0) {
            ++$nogender;
        }
    }

    // Считаем процентное соотношение по полу
    $roundMale = round($male / count($arr) * 100, 1);
    $roundFemale = round($female / count($arr) * 100, 1);
    $roundNogender = round($nogender / count($arr) * 100, 1);

    // формируем вывод результатов с помощью heredoc-синтаксиса
    $stats = <<< GENDERSTATS
  Гендерный состав аудитории:
  ---------------------------
  Мужчины - $roundMale %
  Женщины - $roundFemale %
  Не удалось определить - $roundNogender %
  GENDERSTATS;
    return $stats;
}

// ------------------------------------------------------------------------
echo "\n\n Вывод функции getGenderDescription:\n";
echo getGenderDescription($fullNameString);
// ------------------------------------------------------------------------

// --- Рандомная запись из массива $fullNameString ---
$randomFullNameString = (getPartsFromFullname($fullNameString[array_rand($fullNameString)]));

// -----------------------------------------------------------------
// --- Функция с идеальным подбором пары - getPerfectPartner ---

function getPerfectPartner($surname, $name, $patronomyc, $example_persons_array)
{
    // Приводим написание значений Ф.И.О к нормальному регистру 
    // Первая буква ПРОПИСНАЯ остальные строчные
    $surname = mb_convert_case($surname, MB_CASE_TITLE_SIMPLE);
    $name = mb_convert_case($name, MB_CASE_TITLE_SIMPLE);
    $patronomyc = mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE);

    // Склеиваем ФИО в одну строку, используя функцию getFullnameFromParts
    $fullName = getFullnameFromParts($surname, $name, $patronomyc);

    // Проверяем пол для $fullName с помощью функции $getGenderFromName
    $fullNameGender = getGenderFromName($fullName);
    do {
        // 4 Рандомно выбираем ФИО человека из массива $example_persons_array
        $randomFullNameArr = $example_persons_array[array_rand($example_persons_array)]['fullname'];


        // Проверяем пол для randomFullNameArr с помощью функции $getGenderFromName
        $randomFullNameArrGender = getGenderFromName($randomFullNameArr);
        
    } while ($randomFullNameArrGender == $fullNameGender || $randomFullNameArrGender == 0 || $fullNameGender  == 0);

    // Обезличиваем ФИО с помощью функции $getShortName
    $fullNameShort = getShortName($fullName);
    $randomFullNameArrShort = getShortName($randomFullNameArr);

    // генерируем рандомное число - процент совпадения пары от 50 до 100
    $randomMatch = rand(5000, 10000) / 100;

    $pairMaleFemale = <<< PAIRMALEFEMALE
    Совместимость пары:
    ---------------------------
    $fullNameShort + $randomFullNameArrShort =
    \u{1F49F} Идеально на  $randomMatch %
    PAIRMALEFEMALE;
    return $pairMaleFemale;
}

// ------------------------------------------------------------------------
echo "\n\n Вывод функции getPerfectPartner:\n";
echo getPerfectPartner('маслов', 'АНДРЕЙ', 'пЕтрОвич', $example_persons_array);
 // ------------------------------------------------------------------------