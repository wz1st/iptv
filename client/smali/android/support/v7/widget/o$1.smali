.class Landroid/support/v7/widget/o$1;
.super Landroid/support/v7/widget/z;


# annotations
.annotation system Ldalvik/annotation/EnclosingMethod;
    value = Landroid/support/v7/widget/o;-><init>(Landroid/content/Context;Landroid/util/AttributeSet;IILandroid/content/res/Resources$Theme;)V
.end annotation

.annotation system Ldalvik/annotation/InnerClass;
    accessFlags = 0x0
    name = null
.end annotation


# instance fields
.field final synthetic a:Landroid/support/v7/widget/o$b;

.field final synthetic b:Landroid/support/v7/widget/o;


# direct methods
.method constructor <init>(Landroid/support/v7/widget/o;Landroid/view/View;Landroid/support/v7/widget/o$b;)V
    .locals 0

    iput-object p1, p0, Landroid/support/v7/widget/o$1;->b:Landroid/support/v7/widget/o;

    iput-object p3, p0, Landroid/support/v7/widget/o$1;->a:Landroid/support/v7/widget/o$b;

    invoke-direct {p0, p2}, Landroid/support/v7/widget/z;-><init>(Landroid/view/View;)V

    return-void
.end method


# virtual methods
.method public a()Landroid/support/v7/view/menu/q;
    .locals 1

    iget-object v0, p0, Landroid/support/v7/widget/o$1;->a:Landroid/support/v7/widget/o$b;

    return-object v0
.end method

.method public b()Z
    .locals 1

    iget-object v0, p0, Landroid/support/v7/widget/o$1;->b:Landroid/support/v7/widget/o;

    iget-object v0, v0, Landroid/support/v7/widget/o;->a:Landroid/support/v7/widget/o$b;

    invoke-virtual {v0}, Landroid/support/v7/widget/o$b;->d()Z

    move-result v0

    if-nez v0, :cond_0

    iget-object v0, p0, Landroid/support/v7/widget/o$1;->b:Landroid/support/v7/widget/o;

    iget-object v0, v0, Landroid/support/v7/widget/o;->a:Landroid/support/v7/widget/o$b;

    invoke-virtual {v0}, Landroid/support/v7/widget/o$b;->a()V

    :cond_0
    const/4 v0, 0x1

    return v0
.end method
