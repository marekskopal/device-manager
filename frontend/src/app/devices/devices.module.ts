import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

import { DevicesRoutingModule } from './devices-routing.module';
import {FaIconComponent, FaIconLibrary} from "@fortawesome/angular-fontawesome";
import {faEdit, faPlus, faTrash} from "@fortawesome/free-solid-svg-icons";
import {ListComponent} from "@app/devices/components/list/list.component";
import {LayoutComponent} from "@app/devices/components/layout/layout.component";
import {AddEditComponent} from "@app/devices/components/add-edit/add-edit.component";

@NgModule({
    imports: [
        CommonModule,
        ReactiveFormsModule,
        DevicesRoutingModule,
        FaIconComponent
    ],
    declarations: [
        LayoutComponent,
        ListComponent,
        AddEditComponent
    ]
})
export class DevicesModule {
    public constructor(
        private readonly faIconLibrary: FaIconLibrary
    ) {
        faIconLibrary.addIcons(faPlus, faEdit, faTrash)
    }
}
