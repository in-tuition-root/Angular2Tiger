/**
 * Created by praghav on 5/14/2016.
 */

import {Component, OnInit} from "@angular/core";
import {FormBuilder, ControlGroup, Validators} from "@angular/common";
import {AuthService} from "../../service/AuthenticationService";

@Component({
    selector: 'in-tuition-signin',
    styleUrls: ['app/component/signin/signin.css'],
    templateUrl:'app/component/signin/signin.html'
})

export class SignInComponent implements OnInit {
    myForm: ControlGroup;
    error = false;
    errorMessage = '';

    constructor(private _fb: FormBuilder, private _authService: AuthService) {}

    onSignin() {
        this._authService.signinUser(this.myForm.value);
    }

    ngOnInit():any {
        this.myForm = this._fb.group({
            email: ['', Validators.required],
            password: ['', Validators.required],
        });
    }
}