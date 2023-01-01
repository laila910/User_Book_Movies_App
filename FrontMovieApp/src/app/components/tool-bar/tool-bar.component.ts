import { Component, OnInit} from '@angular/core';
import { ApiService } from 'src/app/api.service';
import { Router } from '@angular/router';
import { FormGroup, FormControl, Validators } from '@angular/forms';
@Component({
  selector: 'app-tool-bar',
  templateUrl: './tool-bar.component.html',
  styleUrls: ['./tool-bar.component.css']
})
export class ToolBarComponent implements OnInit{
  flag: boolean = false;
  flag2:boolean=false;
  admin:boolean=false;
  user:any;
  userInfo:any;
  signInForm  = new FormGroup({
    email: new FormControl('', [Validators.required, Validators.email]),
    password:new FormControl('',[Validators.required,Validators.minLength(3)])
  });
  signUpForm=new FormGroup({
    signup_email:new FormControl('',[Validators.required,Validators.email]),
    username:new FormControl('',[Validators.required,Validators.minLength(3)]),
    signup_password:new FormControl('',[Validators.required]),
    password_confirmation:new FormControl('',[Validators.required])
  });

  constructor(public apiService: ApiService,private router: Router) {
    this.user=localStorage.getItem('userData');
    this.userInfo=JSON.parse(this.user);
    if(this.userInfo.email=='lailaibrahim798@gmail.com'){
      this.admin=true;
    }
   }

  //  exportAllExcel(){
  //   this.apiService.exportAllMoviesUserIntoExcel().subscribe(data=>{
  //     console.log(data);
  //   },(e)=>{console.log(e);},
  //   ()=>{

  //   })
  //  }
  //  exportAllCSV(){
  //   this.apiService.exportAllMoviesUsersIntoCSV().subscribe(data=>{
  //     console.log(data);
  //   },(e)=>{console.log(e)},
  //   ()=>{
      
  //   })
  //  }
  ngOnInit(): void {}
  // get email(){
  //   return this.signInForm.get('email');
  // }
  // get password(){
  //   return this.signInForm.get('password');
  // }
  // get username(){
  //   return this.signUpForm.get('username');
  // }
  // get signup_email(){
  //   return this.signUpForm.get('signup_email');
  // }
  // get signup_password(){
  //   return this.signUpForm.get('signup_password');
  // }
  // get password_confirmation(){
  //   return this.signUpForm.get('password_confirmation');
  // }
  file:any;
 onChange(event:any){
   this.file=event.target.files[0];
  }
userData:any;
  token:any;
  message:any;
  signIn(data: any) {
    this.apiService.login({'email':data.value.email,'password':data.value.password}).subscribe(data=>{
      console.log(data.token);
      this.token=data.token;
      localStorage.setItem('appToken',`bearer ${this.token}`);

      console.log(data.user);
      this.userData=data.user;
      localStorage.setItem('userData', JSON.stringify(this.userData));
    },(e)=>{
      console.log(e.error.message);
      this.message=e.error.message;
      this.flag=true;
    },
    ()=>{

    })
  }
  signUp(data:any){
    const formData = new FormData();
    formData.append('username',data.value.username);
    formData.append('email',data.value.signup_email);
    formData.append('password',data.value.signup_password);
    formData.append('image', this.file,this.file.name);
    formData.append('password_confirmation',data.value.password_confirmation);
    this.apiService.register(formData).subscribe(data=>{
      console.log(data);
      console.log(data.token);
      this.token=data.token;
      localStorage.setItem('appToken',`bearer ${this.token}`);

      console.log(data.user);
      this.userData=data.user;

    },(e)=>{console.log(e)
      console.log(e.error.message);
      this.message=e.error.message;
      this.flag2=true;}
    ,()=>{
      // this.router.navigateByUrl('/dashboard/products')
    })
  }

}
