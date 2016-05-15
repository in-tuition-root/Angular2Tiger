/**
 * Created by nejindal on 5/13/2016.
 */
import {Component, OnInit} from '@angular/core';
import {FormBuilder, ControlGroup, Validators, Control} from "@angular/common";
import {AuthService} from "../../service/AuthenticationService";

@Component({
    selector: 'in-tuition-signup',
    styleUrls: ['app/component/signup/signup.css'],
    templateUrl:'app/component/signup/signup.html',
    providers: [FormBuilder, AuthService]
})

export class SignUpComponent implements OnInit {
    myForm:ControlGroup;
    error = false;
    errorMessage = '';

    constructor(private _fb:FormBuilder, private _authService: AuthService) {
    }

    onSignup() {
        this._authService.signupUser(this.myForm.value);
    }

    ngOnInit():any {
        this.myForm = this._fb.group({
            password: ['', Validators.required],
            confirmPassword: ['', Validators.compose([
                Validators.required,
                this.isEqualPassword.bind(this)
            ])],
        });
    }

    isEmail(control:Control):{[s: string]: boolean} {
        if (!control.value.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
            return {noEmail: true};
        }
    }

    isEqualPassword(control:Control):{[s: string]: boolean} {
        if (!this.myForm) {
            return {passwordsNotMatch: true};

        }
        if (control.value !== this.myForm.controls['password'].value) {
            return {passwordsNotMatch: true};
        }
    }
}