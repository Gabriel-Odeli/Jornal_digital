class TelaPrincipal{
    constructor(menu, categorias, navLinks){
        this.menu = document.querySelector(menu);
        this.categorias = document.querySelector(categorias);
        this.navLinks = document.querySelectorAll(navLinks)
        this.activeClass = "active";
        this.handleClick = this.handleClick.bind(this);
    }

    animaçãoCategorias() {
        this.navLinks.forEach((link) => {
            link.style.animation
            if (link.style.animation = "");
            else(link.style.animation = 'categorias_opacity 0.5s ease forwards 0.5s');
        });
    }

    handleClick() {
        this.categorias.classList.toggle(this.activeClass);
        this.animaçãoCategorias();
    }

    addClickEvent(){
        this.menu.addEventListener("click", this.handleClick);
    }

    init(){
        if(this.menu){
            this.addClickEvent();
        }
        return this;
    }
}

const telaPrincipal = new TelaPrincipal(
    ".menu",
    ".categorias",
    ".categorias li",
)

telaPrincipal.init();