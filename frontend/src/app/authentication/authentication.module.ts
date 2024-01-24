import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

import { AuthenticationRoutingModule } from './authentication-routing.module';
import {LoginComponent} from "@app/authentication/components/login/login.component";
import {LayoutComponent} from "@app/authentication/components/layout/layout.component";

@NgModule({
    imports: [
        CommonModule,
        ReactiveFormsModule,
        AuthenticationRoutingModule
    ],
    declarations: [
        LayoutComponent,
        LoginComponent,
    ]
})
export class AuthenticationModule { }
