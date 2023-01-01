import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { MoviesHomeComponent } from './components/movies-home/movies-home.component';
import { MovieDetailsComponent } from './movie-details/movie-details.component';
import { BookTicketComponent } from './book-ticket/book-ticket.component';
import { ProfileComponent } from './profile/profile.component';
import { LogoutComponent } from './logout/logout.component';

const routes: Routes = [
  {path:'',component:MoviesHomeComponent,title:'Movies Home',pathMatch:'full'},
  {path:'search/:name',component:MoviesHomeComponent,title:'filtered movies',pathMatch:'full'},
  {path:'movies/:id',component:MovieDetailsComponent,title:'Movie Details',pathMatch:'full'},
  {path:'bookTicket/:id',component:BookTicketComponent,title:'book Ticket',pathMatch:'full'},
  {path:'profile',component:ProfileComponent,title:'Profile',pathMatch:'full'},
  {path:'logout/:id',component:LogoutComponent,title:'logout',pathMatch:'full'}
  


];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
