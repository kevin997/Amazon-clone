<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // liste des permissions
        $permissions = [
            //Manage user permission
            ['name' => 'CreateUser'],
            ['name' => 'ReadUser'],
            ['name' => 'UpdateUser'],
            ['name' => 'DeleteUser'],

            //Manage user profile
            ['name' => 'CreateUserProfile'],
            ['name' => 'ReadUserProfile'],
            ['name' => 'UpdateUserProfile'],
            ['name' => 'DeleteUserProfile'],

            //Manage Plan de vente permission
            ['name' => 'CreatePlanVente'],
            ['name' => 'ReadPlanVente'],
            ['name' => 'UpdatePlanVente'],
            ['name' => 'DeletePlanVente'],

            //Manage Abonnement prime permission
            ['name' => 'CreateAbonnementPrime'],
            ['name' => 'ReadAbonnementPrime'],
            ['name' => 'UpdateAbonnementPrime'],
            ['name' => 'DeleteAbonnementPrime'],

            //Manage Store permission
            ['name' => 'CreateStores'],
            ['name' => 'ReadStores'],
            ['name' => 'UpdateStores'],
            ['name' => 'DeleteStores'],

            //Manage Categorie produit permission
            ['name' => 'CreateCategorieProduit'],
            ['name' => 'ReadCategorieProduit'],
            ['name' => 'UpdateCategorieProduit'],
            ['name' => 'DeleteCategorieProduit'],

            //Manage Produits permission
            ['name' => 'CreateProduits'],
            ['name' => 'ReadProduits'],
            ['name' => 'UpdateProduits'],
            ['name' => 'DeleteProduits'],

            //Manage Shopping cart permission
            ['name' => 'CreateShoppingCart'],
            ['name' => 'ReadShoppingCart'],
            ['name' => 'UpdateShoppingCart'],
            ['name' => 'DeleteShoppingCart'],

            //Manage Orders permission
            ['name' => 'CreateOrders'],
            ['name' => 'ReadOrders'],
            ['name' => 'UpdateOrders'],
            ['name' => 'DeleteOrders'],

            //Manage Subscription (amazon prime) permission
            ['name' => 'CreateSubscription'],
            ['name' => 'ReadSubscription'],
            ['name' => 'UpdateSubscription'],
            ['name' => 'DeleteSubscription'],

            //Manage Stocks permission
            ['name' => 'CreateStocks'],
            ['name' => 'ReadStocks'],
            ['name' => 'UpdateStocks'],
            ['name' => 'DeleteStocks'],

            //Manage Bank account permission
            ['name' => 'CreateBankAccount'],
            ['name' => 'ReadBankAccount'],
            ['name' => 'UpdateBankAccount'],
            ['name' => 'DeleteBankAccount'],

            //Manage Credit card permission
            ['name' => 'CreateCreditCard'],
            ['name' => 'ReadCreditCard'],
            ['name' => 'UpdateCreditCard'],
            ['name' => 'DeleteCreditCard'],

            //Manage Payments permissions
            ['name' => 'CreatePayments'],
            ['name' => 'ReadPayments'],
            ['name' => 'UpdatePayments'],
            ['name' => 'DeletePayments'],

            //Manage Comments permission
            ['name' => 'CreateComments'],
            ['name' => 'ReadComments'],
            ['name' => 'UpdateComments'],
            ['name' => 'DeleteComments'],
        ];

        // enregistrement de toutes les permissions du systeme dans la table permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }

        // assignation de toutes les permissions a l'admin
        Role::create(['name' => 'Admin'])->givePermissionTo(Permission::all());

        // creation et assignation de permissions au guest (visiteur)
        $role = Role::create(['name' => 'Guest']);        
        $this->assignGuestPermissions([
            'CreateUser',            
            'CreateShoppingCart',
            'DeleteShoppingCart',            
            'ReadStores',
            'ReadProduits',
            'ReadCategorieProduit',
            'ReadAbonnementPrime',            
        ], $role);

        // creation et assignation de permissions au role customer (acheteur)
        $role = Role::create(['name' => 'Customer']);        
        $this->assignCustomerPermissions([
            'ReadStores',
            'ReadCategorieProduit',
            'ReadProduits',            
            'CreateShoppingCart',
            'ReadShoppingCart',
            'UpdateShoppingCart',
            'CreateOrders',
            'ReadOrders',
            'UpdateOrders',
            'CreateSubscription',
            'ReadSubscription',
            'UpdateSubscription',
            'CreateBankAccount',
            'ReadBankAccount',
            'UpdateBankAccount',
            'CreateCreditCard',
            'ReadCreditCard',
            'UpdateCreditCard',
            'CreatePayments',
            'ReadPayments',
            'UpdatePayments',
            'CreateUser',   // become seller
            'ReadUser',
            'UpdateUser',
            'CreateUserProfile',
            'ReadUserProfile',
            'UpdateUserProfile',
            'CreateComments',
            'ReadComments',
            'UpdateComments',
        ], $role);

        // creation et assignation de permissions au role seller (vendeur)
        $role = Role::create(['name' => 'Seller']);        
        $this->assignSellerPermissions([
            'CreateStores',
            'ReadStores',
            'UpdateStores',
            'CreateCategorieProduit',
            'ReadCategorieProduit',
            'UpdateCategorieProduit',
            'CreateProduits',
            'ReadProduits',
            'UpdateProduits',
            'CreatePlanVente',
            'ReadPlanVente',
            'UpdatePlanVente',
            'CreateStocks',
            'ReadStocks',
            'UpdateStocks',
            'CreateBankAccount',
            'ReadBankAccount',
            'UpdateBankAccount',
            'CreateCreditCard',
            'ReadCreditCard',
            'UpdateCreditCard',
            'ReadUser',
            'UpdateUser',
            'CreateUserProfile',
            'ReadUserProfile',
            'UpdateUserProfile',
            'ReadPayments',
            'ReadOrders',
            'ReadComments',
        ], $role);
    }

    /**
     *
     * @param array $permissions
     * @param \Spatie\Permission\Models\Role $role
     * @return boolean|null
     */
    private function assignGuestPermissions($permissions, $role)
    {
        return $role->givePermissionTo($permissions);
    }

    /**
     *
     * @param array $permissions
     * @param \Spatie\Permission\Models\Role $role
     * @return boolean|null
     */
    private function assignCustomerPermissions($permissions, $role)
    {
        return $role->givePermissionTo($permissions);
    }

    /**
     *
     * @param array $permissions
     * @param \Spatie\Permission\Models\Role $role
     * @return boolean|null| $this
     */
    private function assignSellerPermissions($permissions, $role)
    {
        return $role->givePermissionTo($permissions);
    }
}
