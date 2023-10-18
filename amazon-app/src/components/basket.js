export default class Basket {
    
    // pour creer un panier
    constructor(){
        let basket = localStorage.getItem("basket");

        if(this.basket == null){
            this.basket = [];
        }else{
            this.basket = JSON.parse(basket);
        }
    }

    // mise a jour du panier
    save(){
        localStorage.setItem("basket", JSON.stringify(this.basket));
    }

    // Ajouter un nouveau produit au panier
    add(product){
        
        // on recupere le contenu de la variable panier stocke en local
        let basket = localStorage.getItem("basket");

        if(this.basket == null){
            this.basket = [];
        }else{
            this.basket = JSON.parse(basket);
        }

        
        // variable d'etat
        let done = "";

        // on verifie l'existence du produit
        let foundProduct = this.basket.find(p => p.id == product.id);
        
        if(foundProduct != undefined){
            foundProduct.quantity++;    // le produit existe deja dans le panier (mouvementer la quantite)
            done = "existe";
        }else{
            product.quantity = (product.quantity == undefined)? 1 : product.quantity;
            // on l'ajoute au panier
            this.basket.push(product);                
            done = "n'existe pas";
        }        
        
        // on sauvegarde le panier en local
        localStorage.setItem("basket", JSON.stringify(this.basket));
        console.log(foundProduct);
    }

    //supprimer un produit du panier
    remove(product){
        this.basket = this.basket.filter(p => p.id != product.id);
        this.save();
    }

    // changer la quantite commandee
    changeQuantity(product, quantity){
        let foundProduct = this.basket.find(p => p.id == product.id);

        if(foundProduct != undefined){
            foundProduct.quantity += quantity;

            // on s'assure que la quantite n'est pas negative
            if(foundProduct.quantity <= 0){
                this.remove(product);
            }else{
                this.save()
            }
        }
    }

    // comptabiliser le nombre de produits dans le panier
    getNumberProduct(){
        let number = 0;

        for (let product of this.basket){
            number += product.quantity;
        }

        return number;
    }

    // calculer le total du panier
    getTotalPrice(){
        let total = 0;

        for (let product of this.basket){
            total += product.quantity * product.price;
        }
        
        return total;
    }
}