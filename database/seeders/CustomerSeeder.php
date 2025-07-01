<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\Person;
use App\Models\Contact;
use App\Models\ContactPerFamily;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create contacts first
        $this->createContacts();
        
        // Create families
        $this->createFamilies();
        
        // Create people
        $this->createPeople();
        
        // Link contacts to families
        $this->createContactPerFamilies();
        
        // Create users
        $this->createUsers();
    }

    private function createContacts(): void
    {
        $contacts = [
            ['id' => 1, 'street' => 'Hoofdstraat', 'house_number' => '123', 'postal_code' => '1234AB', 'city' => 'Zevenhuizen', 'email' => 'zevenhuizen@example.com', 'mobile' => '06-12345678'],
            ['id' => 2, 'street' => 'Bergstraat', 'house_number' => '45', 'postal_code' => '5678CD', 'city' => 'Bergkamp', 'email' => 'bergkamp@example.com', 'mobile' => '06-87654321'],
            ['id' => 3, 'street' => 'Heuvelweg', 'house_number' => '67', 'postal_code' => '9012EF', 'city' => 'Heuvelstad', 'email' => 'heuvel@example.com', 'mobile' => '06-11223344'],
            ['id' => 4, 'street' => 'Schilderslaan', 'house_number' => '89', 'postal_code' => '3456GH', 'city' => 'Schierdorp', 'email' => 'schierder@example.com', 'mobile' => '06-99887766'],
            ['id' => 5, 'street' => 'Jongerenstraat', 'house_number' => '12', 'postal_code' => '7890IJ', 'city' => 'Jongeren', 'email' => 'dejong@example.com', 'mobile' => '06-55443322'],
            ['id' => 6, 'street' => 'Bergweg', 'house_number' => '34', 'addition' => 'A', 'postal_code' => '2468KL', 'city' => 'Bergdorp', 'email' => 'vanderberg@example.com', 'mobile' => '06-77889900'],
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }

    private function createFamilies(): void
    {
        $families = [
            ['id' => 1, 'name' => 'ZevenhuizenGezin', 'code' => 'G0001', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 2, 'number_of_babies' => 0, 'total_number_of_people' => 4],
            ['id' => 2, 'name' => 'BergkampGezin', 'code' => 'G0002', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 1, 'number_of_babies' => 1, 'total_number_of_people' => 4],
            ['id' => 3, 'name' => 'HeuvelGezin', 'code' => 'G0003', 'description' => 'Bijstandsgezin', 'number_of_adults' => 2, 'number_of_children' => 0, 'number_of_babies' => 0, 'total_number_of_people' => 2],
            ['id' => 4, 'name' => 'SchierderGezin', 'code' => 'G0004', 'description' => 'Bijstandsgezin', 'number_of_adults' => 1, 'number_of_children' => 0, 'number_of_babies' => 2, 'total_number_of_people' => 3],
            ['id' => 5, 'name' => 'DeJongGezin', 'code' => 'G0005', 'description' => 'Bijstandsgezin', 'number_of_adults' => 1, 'number_of_children' => 1, 'number_of_babies' => 0, 'total_number_of_people' => 2],
            ['id' => 6, 'name' => 'VanderBergGezin', 'code' => 'G0006', 'description' => 'AlleenGaande', 'number_of_adults' => 1, 'number_of_children' => 0, 'number_of_babies' => 0, 'total_number_of_people' => 1],
        ];

        foreach ($families as $family) {
            Family::create($family);
        }
    }

    private function createPeople(): void
    {
        $people = [
            // Employees/Staff
            ['id' => 1, 'family_id' => null, 'first_name' => 'Hans', 'infix' => 'van', 'last_name' => 'Leeuwen', 'date_of_birth' => '1958-02-12', 'person_type' => 'Manager', 'is_representative' => false],
            ['id' => 2, 'family_id' => null, 'first_name' => 'Jan', 'infix' => 'van der', 'last_name' => 'Sluijs', 'date_of_birth' => '1993-04-30', 'person_type' => 'Medewerker', 'is_representative' => false],
            ['id' => 3, 'family_id' => null, 'first_name' => 'Herman', 'infix' => 'den', 'last_name' => 'Duiker', 'date_of_birth' => '1989-08-30', 'person_type' => 'Vrijwilliger', 'is_representative' => false],

            // ZevenhuizenGezin (Family 1)
            ['id' => 4, 'family_id' => 1, 'first_name' => 'Johan', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '1990-05-20', 'person_type' => 'Klant', 'is_representative' => true],
            ['id' => 5, 'family_id' => 1, 'first_name' => 'Sarah', 'infix' => 'den', 'last_name' => 'Dolder', 'date_of_birth' => '1985-03-23', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 6, 'family_id' => 1, 'first_name' => 'Theo', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2015-03-08', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 7, 'family_id' => 1, 'first_name' => 'Jantien', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2016-09-20', 'person_type' => 'Klant', 'is_representative' => false],

            // BergkampGezin (Family 2)
            ['id' => 8, 'family_id' => 2, 'first_name' => 'Arjan', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '1968-07-12', 'person_type' => 'Klant', 'is_representative' => true],
            ['id' => 9, 'family_id' => 2, 'first_name' => 'Janneke', 'infix' => null, 'last_name' => 'Sanders', 'date_of_birth' => '1969-05-11', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 10, 'family_id' => 2, 'first_name' => 'Stein', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '2009-02-02', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 11, 'family_id' => 2, 'first_name' => 'Judith', 'infix' => null, 'last_name' => 'Bergkamp', 'date_of_birth' => '2022-02-05', 'person_type' => 'Klant', 'is_representative' => false],

            // HeuvelGezin (Family 3)
            ['id' => 12, 'family_id' => 3, 'first_name' => 'Mazin', 'infix' => 'van', 'last_name' => 'Vliet', 'date_of_birth' => '1968-08-18', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 13, 'family_id' => 3, 'first_name' => 'Selma', 'infix' => 'van de', 'last_name' => 'Heuvel', 'date_of_birth' => '1965-09-04', 'person_type' => 'Klant', 'is_representative' => true],

            // SchierderGezin (Family 4)
            ['id' => 14, 'family_id' => 4, 'first_name' => 'Eva', 'infix' => null, 'last_name' => 'Schierder', 'date_of_birth' => '2000-04-07', 'person_type' => 'Klant', 'is_representative' => true],
            ['id' => 15, 'family_id' => 4, 'first_name' => 'Felida', 'infix' => null, 'last_name' => 'Schierder', 'date_of_birth' => '2021-11-29', 'person_type' => 'Klant', 'is_representative' => false],
            ['id' => 16, 'family_id' => 4, 'first_name' => 'Devin', 'infix' => null, 'last_name' => 'Schierder', 'date_of_birth' => '2024-03-01', 'person_type' => 'Klant', 'is_representative' => false],

            // DeJongGezin (Family 5)
            ['id' => 17, 'family_id' => 5, 'first_name' => 'Frieda', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '1980-09-04', 'person_type' => 'Klant', 'is_representative' => true],
            ['id' => 18, 'family_id' => 5, 'first_name' => 'Simeon', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '2018-05-23', 'person_type' => 'Klant', 'is_representative' => false],

            // VanderBergGezin (Family 6)
            ['id' => 19, 'family_id' => 6, 'first_name' => 'Hanna', 'infix' => 'van der', 'last_name' => 'Berg', 'date_of_birth' => '1999-09-09', 'person_type' => 'Klant', 'is_representative' => true],
        ];

        foreach ($people as $person) {
            Person::create($person);
        }
    }

    private function createContactPerFamilies(): void
    {
        $contactPerFamilies = [
            ['id' => 1, 'family_id' => 1, 'contact_id' => 1],
            ['id' => 2, 'family_id' => 2, 'contact_id' => 2],
            ['id' => 3, 'family_id' => 3, 'contact_id' => 3],
            ['id' => 4, 'family_id' => 4, 'contact_id' => 4],
            ['id' => 5, 'family_id' => 5, 'contact_id' => 5],
            ['id' => 6, 'family_id' => 6, 'contact_id' => 6],
        ];

        foreach ($contactPerFamilies as $contactPerFamily) {
            ContactPerFamily::create($contactPerFamily);
        }
    }

    private function createUsers(): void
    {
        // Get roles (assuming they exist from DatabaseSeeder)
        $managerRole = Role::where('name', 'Manager')->first();
        $employeeRole = Role::where('name', 'Employee')->first();
        $volunteerRole = Role::where('name', 'Volunteer')->first();

        $users = [
            [
                'id' => 1,
                'person_id' => 1,
                'login_name' => 'hans',
                'name' => 'hans@maaskantje.nl',
                'email' => 'hans@maaskantje.nl',
                'password' => Hash::make('$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvol/AXVowCp/DL6zkJF0i'),
                'is_logged_in' => true,
                'logged_in_at' => '2024-03-13 17:03:06',
                'logged_out_at' => null,
                'role' => $managerRole
            ],
            [
                'id' => 2,
                'person_id' => 2,
                'login_name' => 'jan',
                'name' => 'jan@maaskantje.nl',
                'email' => 'jan@maaskantje.nl',
                'password' => Hash::make('$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvol/AXVowCp/DL3zkJF6i'),
                'is_logged_in' => false,
                'logged_in_at' => '2024-03-13 15:13:23',
                'logged_out_at' => '2024-03-13 15:23:46',
                'role' => $employeeRole
            ],
            [
                'id' => 3,
                'person_id' => 3,
                'login_name' => 'herman',
                'name' => 'herman@maaskantje.nl',
                'email' => 'herman@maaskantje.nl',
                'password' => Hash::make('$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvol/AXVowCp/DL9zkJF2i'),
                'is_logged_in' => true,
                'logged_in_at' => '2024-06-20 12:05:20',
                'logged_out_at' => null,
                'role' => $volunteerRole
            ]
        ];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);
            
            $user = User::create($userData);
            if ($role) {
                $user->roles()->attach($role->id);
            }
        }
    }
}
