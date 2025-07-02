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
            ['id' => 1, 'street' => 'Prinses Irenestraat', 'house_number' => '12', 'addition' => 'A', 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 'j.van.zevenhuizen@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 2, 'street' => 'Gibraltarstraat', 'house_number' => '234', 'addition' => NULL, 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 'a.bergkamp@hotmail.com', 'mobile' => '+31 623456123'],
            ['id' => 3, 'street' => 'Der Kinderenstraat', 'house_number' => '456', 'addition' => 'Bis', 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 's.van.de.heuvel@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 4, 'street' => 'Nachtegaalstraat', 'house_number' => '233', 'addition' => 'A', 'postal_code' => '5271TJ', 'city' => 'Maaskantje', 'email' => 'e.schierder@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 5, 'street' => 'Bertram Russellstraat', 'house_number' => '45', 'addition' => NULL, 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 'f.de.jong@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 6, 'street' => 'Leonardo Da VinciHof', 'house_number' => '34', 'addition' => NULL, 'postal_code' => '5271ZE', 'city' => 'Maaskantje', 'email' => 'h.van.der.berg@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 7, 'street' => 'Siegfried Knutsenlaan', 'house_number' => '234', 'addition' => NULL, 'postal_code' => '5271ZE', 'city' => 'Maaskantje', 'email' => 't.ter.weiden@ah.nl', 'mobile' => '+31 623456123'],
            ['id' => 8, 'street' => 'Theo de Bokstraat', 'house_number' => '256', 'addition' => NULL, 'postal_code' => '5271ZH', 'city' => 'Maaskantje', 'email' => 'j.pastoor@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 9, 'street' => 'Meester van Leerhof', 'house_number' => '2', 'addition' => 'A', 'postal_code' => '5271ZH', 'city' => 'Maaskantje', 'email' => 'm.vazid@gemeenteutrecht.nl', 'mobile' => '+31 623456123'],
            ['id' => 10, 'street' => 'Van Wemelenplantsoen', 'house_number' => '300', 'addition' => NULL, 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 'b.van.driel@gmail.com', 'mobile' => '+31 623456123'],
            ['id' => 11, 'street' => 'Treflingenhof', 'house_number' => '20', 'addition' => NULL, 'postal_code' => '5271TH', 'city' => 'Maaskantje', 'email' => 'j.pastorius@gmail.com', 'mobile' => '+31 623456356'],
            ['id' => 12, 'street' => 'Veldhoen', 'house_number' => '31', 'addition' => NULL, 'postal_code' => '5271ZE', 'city' => 'Maaskantje', 'email' => 's.dollaard@gmail.com', 'mobile' => '+31 623452314'],
            ['id' => 13, 'street' => 'ScheringaDreef', 'house_number' => '37', 'addition' => NULL, 'postal_code' => '5271ZE', 'city' => 'Vught', 'email' => 'j.blokker@gemeentevught.nl', 'mobile' => '+31 623452314'],
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
            ['id' => 1, 'family_id' => NULL, 'first_name' => 'Hans', 'infix' => 'van', 'last_name' => 'Leeuwen', 'date_of_birth' => '1958-02-12', 'person_type' => 'Manager', 'is_representative' => 0],
            ['id' => 2, 'family_id' => NULL, 'first_name' => 'Jan', 'infix' => 'van der', 'last_name' => 'Sluijs', 'date_of_birth' => '1993-04-30', 'person_type' => 'Medewerker', 'is_representative' => 0],
            ['id' => 3, 'family_id' => NULL, 'first_name' => 'Herman', 'infix' => 'den', 'last_name' => 'Duiker', 'date_of_birth' => '1989-08-30', 'person_type' => 'Vrijwilliger', 'is_representative' => 0],
            ['id' => 4, 'family_id' => 1, 'first_name' => 'Johan', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '1990-05-20', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 5, 'family_id' => 1, 'first_name' => 'Sarah', 'infix' => 'den', 'last_name' => 'Dolder', 'date_of_birth' => '1985-03-23', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 6, 'family_id' => 1, 'first_name' => 'Theo', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2015-03-08', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 7, 'family_id' => 1, 'first_name' => 'Jantien', 'infix' => 'van', 'last_name' => 'Zevenhuizen', 'date_of_birth' => '2016-09-20', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 8, 'family_id' => 2, 'first_name' => 'Arjan', 'infix' => NULL, 'last_name' => 'Bergkamp', 'date_of_birth' => '1968-07-12', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 9, 'family_id' => 2, 'first_name' => 'Janneke', 'infix' => NULL, 'last_name' => 'Sanders', 'date_of_birth' => '1969-05-11', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 10, 'family_id' => 2, 'first_name' => 'Stein', 'infix' => NULL, 'last_name' => 'Bergkamp', 'date_of_birth' => '2009-02-02', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 11, 'family_id' => 2, 'first_name' => 'Judith', 'infix' => NULL, 'last_name' => 'Bergkamp', 'date_of_birth' => '2022-02-05', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 12, 'family_id' => 3, 'first_name' => 'Mazin', 'infix' => 'van', 'last_name' => 'Vliet', 'date_of_birth' => '1968-08-18', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 13, 'family_id' => 3, 'first_name' => 'Selma', 'infix' => 'van de', 'last_name' => 'Heuvel', 'date_of_birth' => '1965-09-04', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 14, 'family_id' => 4, 'first_name' => 'Eva', 'infix' => NULL, 'last_name' => 'Schierder', 'date_of_birth' => '2000-04-07', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 15, 'family_id' => 4, 'first_name' => 'Felicia', 'infix' => NULL, 'last_name' => 'Schierder', 'date_of_birth' => '2021-11-29', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 16, 'family_id' => 4, 'first_name' => 'Devin', 'infix' => NULL, 'last_name' => 'Schierder', 'date_of_birth' => '2024-03-01', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 17, 'family_id' => 5, 'first_name' => 'Frieda', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '1980-09-04', 'person_type' => 'Klant', 'is_representative' => 1],
            ['id' => 18, 'family_id' => 5, 'first_name' => 'Simeon', 'infix' => 'de', 'last_name' => 'Jong', 'date_of_birth' => '2018-05-23', 'person_type' => 'Klant', 'is_representative' => 0],
            ['id' => 19, 'family_id' => 6, 'first_name' => 'Hanna', 'infix' => 'van der', 'last_name' => 'Berg', 'date_of_birth' => '1999-09-09', 'person_type' => 'Klant', 'is_representative' => 1],
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
