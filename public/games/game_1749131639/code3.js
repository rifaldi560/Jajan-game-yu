gdjs.deathmenuCode = {};
gdjs.deathmenuCode.localVariables = [];
gdjs.deathmenuCode.GDBorderedHudObjects1= [];
gdjs.deathmenuCode.GDBorderedHudObjects2= [];
gdjs.deathmenuCode.GDLargeExitButtonObjects1= [];
gdjs.deathmenuCode.GDLargeExitButtonObjects2= [];
gdjs.deathmenuCode.GDloseObjects1= [];
gdjs.deathmenuCode.GDloseObjects2= [];


gdjs.deathmenuCode.eventsList0 = function(runtimeScene) {

{

gdjs.copyArray(runtimeScene.getObjects("LargeExitButton"), gdjs.deathmenuCode.GDLargeExitButtonObjects1);

let isConditionTrue_0 = false;
isConditionTrue_0 = false;
for (var i = 0, k = 0, l = gdjs.deathmenuCode.GDLargeExitButtonObjects1.length;i<l;++i) {
    if ( gdjs.deathmenuCode.GDLargeExitButtonObjects1[i].getBehavior("ButtonFSM").IsClicked((typeof eventsFunctionContext !== 'undefined' ? eventsFunctionContext : undefined)) ) {
        isConditionTrue_0 = true;
        gdjs.deathmenuCode.GDLargeExitButtonObjects1[k] = gdjs.deathmenuCode.GDLargeExitButtonObjects1[i];
        ++k;
    }
}
gdjs.deathmenuCode.GDLargeExitButtonObjects1.length = k;
if (isConditionTrue_0) {
{gdjs.evtTools.runtimeScene.replaceScene(runtimeScene, "FullSokobanGame", false);
}}

}


};

gdjs.deathmenuCode.func = function(runtimeScene) {
runtimeScene.getOnceTriggers().startNewFrame();

gdjs.deathmenuCode.GDBorderedHudObjects1.length = 0;
gdjs.deathmenuCode.GDBorderedHudObjects2.length = 0;
gdjs.deathmenuCode.GDLargeExitButtonObjects1.length = 0;
gdjs.deathmenuCode.GDLargeExitButtonObjects2.length = 0;
gdjs.deathmenuCode.GDloseObjects1.length = 0;
gdjs.deathmenuCode.GDloseObjects2.length = 0;

gdjs.deathmenuCode.eventsList0(runtimeScene);
gdjs.deathmenuCode.GDBorderedHudObjects1.length = 0;
gdjs.deathmenuCode.GDBorderedHudObjects2.length = 0;
gdjs.deathmenuCode.GDLargeExitButtonObjects1.length = 0;
gdjs.deathmenuCode.GDLargeExitButtonObjects2.length = 0;
gdjs.deathmenuCode.GDloseObjects1.length = 0;
gdjs.deathmenuCode.GDloseObjects2.length = 0;


return;

}

gdjs['deathmenuCode'] = gdjs.deathmenuCode;
