<header id="inicio">
    <div class="inicio">
        <h1><?php echo $titulo ?></h1>
        <p><?php echo $descripcion ?></p>
        <div>
            <?php 
                if($hasLogin){
            ?>
                <a href="/login">Login</a>
            <?php
                } if($hasSignin){
            ?>
                <a href="/signin">Registrate</a>
            <?php 
                } if($hasContact){
            ?>
                <a href="/#contacto">Contáctanos</a>
            <?php } ?>
        </div>
    </div>
</header>
<main>
    <section id="servicios" class="container">
        <h5>¿Que podemos ofrecerle?</h5>
        <h1>Nuestros Increíbles Servicios</h1>
        <p>Disfrute de la mejor calidad y atención con nosotros, pruébelo <b><a href="#contacto">¡Ahora mismo!</a></b></p>
        <div class="row container-fluid">
            <article class="col-xl-4 col-md-6 col-12 me-md-4 me-0">
                <i class="fa-solid fa-ranking-star"></i>
                <h2>Marketing Digital</h2>
                <p>Nos encargamos de crear estrategias, difundir mensajes y alinear objetivos comerciales, creando contenido en medios digitales que generen interacciones y conversión sobre tus clientes.</p>
                <a href="#">Saber Más</a>
            </article>
            <article class="col-xl-4 col-md-6 col-12 me-xl-4 me-0 mt-md-0 mt-5">
                <i class="fa-solid fa-code"></i>
                <h2>Desarrollo Web</h2>
                <p>Potencia tu imagen y presencia con una página web, contar con una web hace posible tener alcance a nivel mundial, aumentando tu ventaja competitiva.</p>
                <a href="#">Saber Más</a>
            </article>
            <article class="col-xl-4 col-md-6 col-12 me-xl-4 me-0 mt-xl-0 mt-5">
                <i class="fa-solid fa-palette"></i>
                <h2>Branding y logos</h2>
                <p>No solo la publicidad y las ventas son importantes, tener un buen logo, una buena paleta y una imagen profesional y atractiva, son la clave para lograr el éxito de tu negocio.</p>
                <a href="#">Saber Más</a>
            </article>
        </div>
        <div class="row mt-5 container-fluid">
            <article class="col-xl-4 col-md-6 col-12 me-md-4 me-0">
                <i class="fa-solid fa-star"></i>
                <h2>Campañas RRSS</h2>
                <p>Las redes sociales se han convertido en la nueva arma de promoción para los negocios, por ende, es importante que las conviertas en tus mejores aliadas, usándolas para crecer cada vez más.</p>
                <a href="#">Saber Más</a>
            </article>
            <article class="col-xl-4 col-md-6 col-12 me-xl-4 me-0 mt-md-0 mt-5">
                <i class="fa-solid fa-laptop"></i>
                <h2>Campañas SEM</h2>
                <p>Optimiza la visibilidad de tu página web con el uso de herramientas y estrategias que te permitan adquirir una mayor cantidad de visualizaciones a través de los buscadores.</p>
                <a href="#">Saber Más</a>
            </article>
            <article class="col-xl-4 col-md-6 col-12 me-xl-4 me-0 mt-xl-0 mt-5">
                <i class="fa-solid fa-headphones"></i>
                <h2>Asesorías</h2>
                <p>En JG Studio queremos que siempre te vaya bien, por ende, estudiamos tu marca y nos tomamos el tiempo para asesorarte y guiarte en este mundo de la tecnología.</p>
                <a href="#">Saber Más</a>
            </article>
        </div>
    </section>
    <section id="portafolio" class="">
        <h5>Algunos de nuestros proyectos</h5>
        <h1>Proyectos más recientes</h1>
        <p>En JG Studio dejamos que nuestros proyectos y números hablen por nosotros, demostrando la <b>Calidad</b> y <b>Profesionalismo</b> de nuestros servicios.</p>
        <div class="">
            <article class="mt-4">
                <div class="bg-portafolio"></div>
                <img src="build/img/rr78.png" alt="rr78 JG Studio">
                <div class="contenido">
                    <h5>Diseño Web</h5>
                    <h1>Repuestos R&R78</h1>
                    <a href="http://rr78.42web.io" target="_blank">Ver</a>
                </div>
            </article>
            <article class="mt-4">
                <div class="bg-portafolio"></div>
                <img src="build/img/serviciototal.png" alt="servicio total JG Studio">
                <div class="contenido">
                    <h5>Diseño Web</h5>
                    <h1>Servicio Total</h1>
                    <a href="http://serviciototal.42web.io" target="_blank">Ver</a>
                </div>
            </article>
            <article class="mt-4">
                <div class="bg-portafolio"></div>
                <img src="build/img/oncars.png" alt="oncars JG Studio">
                <div class="contenido">
                    <h5>Diseño Web</h5>
                    <h1>Oncar's</h1>
                    <a href="http://www.oncars.42web.io" target="_blank">Ver</a>
                </div>
            </article>
            <article class="mt-4">
                <div class="bg-portafolio"></div>
                <img src="build/img/rr78rs.png" alt="rr78 JG Studio">
                <div class="contenido">
                    <h5>RRSS</h5>
                    <h1>Repuestos RR78</h1>
                    <a href="https://www.instagram.com/repuestosrr78/" target="_blank">Ver</a>
                </div>
            </article>
        </div>
        <a class="my-5" href="#">MÁS PROYECTOS</a>
    </section>
    <section id="about" class="container-fluid">
        <div class="">
            <div>
                <h5>¡Es un gusto que nos conozcas!</h5>
                <h1>Un poco de Nosotros</h1>
                <img src="build/img/about.png" alt="sobre JG Studio">
            </div>
            <div class="">
                <article class="me-4">
                    <i class="fa-solid fa-n"></i>
                    <h4>Sobre Nosotros</h4>
                    <p>Somos una Agencia multidiciplinaria especializada en el marketing digital y desarrollo web, capaces de satisfacer todas tus necesidades a nivel digital.</p>
                </article>
                <article class="me-lg-0 me-4">
                    <i class="fa-solid fa-handshake"></i>
                    <h4>Misión</h4>
                    <p>Nuestra misión es hacerte crecer digitalmente a través de todos los medios existentes en el mundo, convirtiendo así a tus visitantes en tus mejores clientes.</p>
                </article>
                <article class="">
                    <i class="fa-solid fa-glasses"></i>
                    <h4>Visión</h4>
                    <p>Nuestra visión es hacer que la mayor cantidad de empresas y marcas personales crezcan y se den a conocer aún más gracias a nuestras estrategias de Marketing Digital.</p>
                </article>
                <article class="">
                    <i class="fa-regular fa-flag"></i>
                    <h4>Intereses</h4>
                    <p>Nuestro interés esta en que consigas un mayor alcance del que te imaginas, atacando a todos los frentes digitalmente posibles de manera profesional y con la mejor calidad.</p>
                </article>
            </div>
        </div>
    </section>
    <section id="contacto" class="container-fluid">
        <div>
            <h5>¡Manos a la obra!</h5>
            <h1>Contáctanos</h1>
            <p>En JG Studio estaremos siempre <b>Complacidos</b> de atenderte, contáctanos a través del método de tu preferencia, y sé testigo de nuestros <b>Excelentes Servicios</b> y de la <b>Calidad</b> de nuestro trabajo.</p>
        </div>
        <div id="social-media" class="container row">
            <a href="https://api.whatsapp.com/send?phone=584267799128&text=%C2%A1Hola!,%20Me%20gustar%C3%ADa%20saber%20mas%20sobre..." target="_blank" class="me-sm-4 me-0 col-3">
                <i class="fa-brands fa-whatsapp"></i>
                <h1>Whatsapp</h1>
                <h2>+58 414-5598216</h2>
                <h2>+58 426-7799128</h2>
                <div class="circle"></div>
            </a>
            <a href="https://www.instagram.com/JG Studiove/" target="_blank" class="me-lg-4 me-0 col-3">
                <i class="fa-brands fa-instagram"></i>
                <h1>Instagram</h1>
                <h2>@JG Studiove</h2>
                <div class="circle"></div>
            </a>
            <a href="https://www.facebook.com/JG StudioVE/" target="_blank" class="me-xl-4 me-lg-0 me-sm-4 me-0 col-3">
                <i class="fa-brands fa-facebook-f"></i>
                <h1>Facebook</h1>
                <h2>JG Studio</h2>
                <div class="circle"></div>
            </a>
            <a href="#formulario" class="col-3">
                <i class="fa-regular fa-envelope"></i>
                <h1>Email</h1>
                <h2>JG Studiove@gmail.com</h2>
                <div class="circle"></div>
            </a>
        </div>
        <div id="citas" class="container-fluid">
            <div class="row container">
                <section class="col-md-5 col-12">
                    <h1>¡Agenda una video llamada!</h1>
                    <p>Agenda una llamada con nosotros, elige el día y la hora de tu preferencia y hablemos de como podemos ayudarte, recuerda que esta llamada es <b>¡Completamente Gratuita!</b></p>
                    <a href="#formulario">Prefiero enviar un correo</a>
                </section>
                <section class="col-md-5 col-sm-7 col-12 mt-md-0 mt-5">
                    <!-- Principio del widget integrado de Calendly -->
                    <div class="calendly-inline-widget" data-url="https://calendly.com/jgstudiomktg/30min?hide_event_type_details=1&hide_gdpr_banner=1" style="min-width:320px;height:700px;"></div>
                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                    <!-- Final del widget integrado de Calendly -->
                </section>
            </div>
        </div>
        <div id="formulario" class="container-fluid">
            <section>
                <h5>¡EscrÍbenos YA!</h5>
                <h1>Envíanos tu mensaje</h1>
                <p>Estaremos complacidos de <b>Atenderte</b></p>
                <form action="#"  id="form">
                    <input id="nombre" class="form-control mb-3" type="text" placeholder="Nombre:">
                    <input id="email" class="form-control mb-3" type="text" placeholder="Email:">
                    <textarea id="mensaje" class="form-control" cols="30" rows="5" placeholder="Mensaje:"></textarea>
                    <input id="btnCorreo" type="submit" value="Enviar">
                    <a id="btnMailto" href=""></a>
                </form>
            </section>
            <section>
                <img src="build/img/correo.png" alt="correo-JG Studio">
            </section>
        </div>
    </section>
</main>