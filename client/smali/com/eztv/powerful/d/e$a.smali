.class Lcom/eztv/powerful/d/e$a;
.super Ljava/lang/Object;

# interfaces
.implements Landroid/view/View$OnClickListener;


# annotations
.annotation system Ldalvik/annotation/EnclosingClass;
    value = Lcom/eztv/powerful/d/e;
.end annotation

.annotation system Ldalvik/annotation/InnerClass;
    accessFlags = 0x2
    name = "a"
.end annotation


# instance fields
.field a:I

.field final synthetic b:Lcom/eztv/powerful/d/e;


# direct methods
.method public constructor <init>(Lcom/eztv/powerful/d/e;I)V
    .locals 0

    iput-object p1, p0, Lcom/eztv/powerful/d/e$a;->b:Lcom/eztv/powerful/d/e;

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    iput p2, p0, Lcom/eztv/powerful/d/e$a;->a:I

    return-void
.end method


# virtual methods
.method public onClick(Landroid/view/View;)V
    .locals 2

    iget-object v0, p0, Lcom/eztv/powerful/d/e$a;->b:Lcom/eztv/powerful/d/e;

    invoke-static {v0}, Lcom/eztv/powerful/d/e;->a(Lcom/eztv/powerful/d/e;)Lcom/eztv/powerful/d/b;

    move-result-object v0

    if-eqz v0, :cond_0

    iget-object v0, p0, Lcom/eztv/powerful/d/e$a;->b:Lcom/eztv/powerful/d/e;

    invoke-static {v0}, Lcom/eztv/powerful/d/e;->a(Lcom/eztv/powerful/d/e;)Lcom/eztv/powerful/d/b;

    move-result-object v0

    iget v1, p0, Lcom/eztv/powerful/d/e$a;->a:I

    invoke-interface {v0, p1, v1}, Lcom/eztv/powerful/d/b;->a(Landroid/view/View;I)V

    :cond_0
    return-void
.end method