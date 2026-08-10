<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $teacher_id
 * @property int $cycle_id
 * @property string|null $section
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle $cycle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentAssignment> $studentAssignments
 * @property-read int|null $student_assignments_count
 * @property-read \App\Models\Teacher $teacher
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Assignment whereUpdatedAt($value)
 */
	class Assignment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $study_plan_id
 * @property string $skill
 * @property string $type
 * @property string $level
 * @property string $content
 * @property string|null $student_response
 * @property string|null $speech_transcript
 * @property string|null $ai_feedback
 * @property numeric|null $ai_score
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\StudyPlan $studyPlan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereAiFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereAiScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereSpeechTranscript($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStudentResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereStudyPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Challenge whereUpdatedAt($value)
 */
	class Challenge extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $rubric_id
 * @property string $name
 * @property string|null $description
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $grades
 * @property-read int|null $grades_count
 * @property-read \App\Models\Rubric|null $rubric
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereRubricId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Criterion whereUpdatedAt($value)
 */
	class Criterion extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $year
 * @property string $semester
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Assignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Unit> $units
 * @property-read int|null $units_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereSemester($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cycle whereYear($value)
 */
	class Cycle extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $rubric_id
 * @property int|null $unit_id
 * @property string $title
 * @property string $type
 * @property string $date
 * @property int $weight
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $grades
 * @property-read int|null $grades_count
 * @property-read \App\Models\Rubric $rubric
 * @property-read \App\Models\Unit|null $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereRubricId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Evaluation whereWeight($value)
 */
	class Evaluation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\School> $schools
 * @property-read int|null $schools_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $evaluation_id
 * @property int $student_id
 * @property array<array-key, mixed> $scores
 * @property float $total
 * @property string|null $feedback
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $score
 * @property-read \App\Models\Evaluation $evaluation
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereEvaluationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereScores($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grade whereUpdatedAt($value)
 */
	class Grade extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Permission withoutTeam($teams)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $attempt
 * @property array<array-key, mixed> $answers
 * @property string $assigned_level
 * @property array<array-key, mixed> $strengths
 * @property array<array-key, mixed> $weaknesses
 * @property string $ai_analysis
 * @property \Illuminate\Support\Carbon $taken_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Student $student
 * @property-read \App\Models\StudyPlan|null $studyPlan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereAiAnalysis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereAnswers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereAssignedLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereAttempt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereStrengths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereTakenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlacementExam whereWeaknesses($value)
 */
	class PlacementExam extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $unit_id
 * @property string $title
 * @property string $platform
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Unit $unit
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Practice whereUrl($value)
 */
	class Practice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $type
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Criterion> $criteria
 * @property-read int|null $criteria_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Evaluation> $evaluations
 * @property-read int|null $evaluations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rubric whereUpdatedAt($value)
 */
	class Rubric extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $faculty_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Faculty $faculty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|School whereUpdatedAt($value)
 */
	class School extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $cycle_id
 * @property int $school_id
 * @property string $code
 * @property string|null $level
 * @property string|null $strengths
 * @property string|null $weaknesses
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cycle $cycle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Grade> $grades
 * @property-read int|null $grades_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PlacementExam> $placementExams
 * @property-read int|null $placement_exams_count
 * @property-read \App\Models\School $school
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StudentAssignment> $studentAssignments
 * @property-read int|null $student_assignments_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereStrengths($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Student whereWeaknesses($value)
 */
	class Student extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $assignment_id
 * @property int $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Assignment $assignment
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment whereAssignmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudentAssignment whereUpdatedAt($value)
 */
	class StudentAssignment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $student_id
 * @property int $placement_exam_id
 * @property string $level
 * @property array<array-key, mixed> $plan
 * @property bool $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Challenge> $challenges
 * @property-read int|null $challenges_count
 * @property-read \App\Models\PlacementExam $placementExam
 * @property-read \App\Models\Student $student
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan wherePlacementExamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan wherePlan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StudyPlan whereUpdatedAt($value)
 */
	class StudyPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $school_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Assignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\School $school
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Teacher whereUserId($value)
 */
	class Teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $cycle_id
 * @property string $name
 * @property int $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Assignment> $assignments
 * @property-read int|null $assignments_count
 * @property-read \App\Models\Cycle $cycle
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Evaluation> $evaluations
 * @property-read int|null $evaluations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Practice> $practices
 * @property-read int|null $practices_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereCycleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Unit whereUpdatedAt($value)
 */
	class Unit extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Student|null $student
 * @property-read \App\Models\Teacher|null $teacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $teams
 * @property-read int|null $teams_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, ?string $guard = null, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User team($teams, bool $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, ?string $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTeam($teams)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

