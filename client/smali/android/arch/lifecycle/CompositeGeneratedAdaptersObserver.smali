.class public Landroid/arch/lifecycle/CompositeGeneratedAdaptersObserver;
.super Ljava/lang/Object;

# interfaces
.implements Landroid/arch/lifecycle/GenericLifecycleObserver;


# instance fields
.field private final a:[Landroid/arch/lifecycle/b;


# direct methods
.method constructor <init>([Landroid/arch/lifecycle/b;)V
    .locals 0

    invoke-direct {p0}, Ljava/lang/Object;-><init>()V

    iput-object p1, p0, Landroid/arch/lifecycle/CompositeGeneratedAdaptersObserver;->a:[Landroid/arch/lifecycle/b;

    return-void
.end method


# virtual methods
.method public a(Landroid/arch/lifecycle/e;Landroid/arch/lifecycle/c$a;)V
    .locals 6

    const/4 v0, 0x0

    new-instance v2, Landroid/arch/lifecycle/i;

    invoke-direct {v2}, Landroid/arch/lifecycle/i;-><init>()V

    iget-object v3, p0, Landroid/arch/lifecycle/CompositeGeneratedAdaptersObserver;->a:[Landroid/arch/lifecycle/b;

    array-length v4, v3

    move v1, v0

    :goto_0
    if-ge v1, v4, :cond_0

    aget-object v5, v3, v1

    invoke-interface {v5, p1, p2, v0, v2}, Landroid/arch/lifecycle/b;->a(Landroid/arch/lifecycle/e;Landroid/arch/lifecycle/c$a;ZLandroid/arch/lifecycle/i;)V

    add-int/lit8 v1, v1, 0x1

    goto :goto_0

    :cond_0
    iget-object v1, p0, Landroid/arch/lifecycle/CompositeGeneratedAdaptersObserver;->a:[Landroid/arch/lifecycle/b;

    array-length v3, v1

    :goto_1
    if-ge v0, v3, :cond_1

    aget-object v4, v1, v0

    const/4 v5, 0x1

    invoke-interface {v4, p1, p2, v5, v2}, Landroid/arch/lifecycle/b;->a(Landroid/arch/lifecycle/e;Landroid/arch/lifecycle/c$a;ZLandroid/arch/lifecycle/i;)V

    add-int/lit8 v0, v0, 0x1

    goto :goto_1

    :cond_1
    return-void
.end method
