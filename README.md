# pi_3a35
### 'pi3a35' dataBase Name
<p> <br> </p>
<h4>templates structure</h4>
<p> manipulate each component separetly  </p>

- base.html.twig   ( default template front-office ) [ includes below files]
  - z_base_front_structure : (folder)
    - footer_front.html.twig
    - home.html.twig
    - navbar_front.html.twig
    - topbar_fron.html.twig
- base_b.html.twig ( default template back-office ) [ includes below files] 
  - z_base_back_structure (folder)
    - footerb.html.twig
    - home.html.twig
    - navbarb.html.twig
    - sidebarb.html.twig
    - 
#

<h4>  home routes </h4> 
<p> manipulate each component separetly  </p>
- back_home [ @Route '/admin' ]
  - index.html.twig
    - 
- front_home [ @Route '/' ]
  - index.html.twig
    - 
<h3> commonly-used-table-attributes  : </h3>
<h4> 'user' :  </h4>
  <pre>   firstName/lastName/email/id/appointments </pre>
<h4> 'docor','nurse' : </h4> 
   <pre>   id/speciality/calandarDays/phone  <pre>
